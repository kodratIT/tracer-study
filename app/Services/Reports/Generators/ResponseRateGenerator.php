<?php

namespace App\Services\Reports\Generators;

use Modules\Reports\Models\Report;
use Illuminate\Support\Facades\DB;

class ResponseRateGenerator extends BaseGenerator
{
    public function generate(Report $report): array
    {
        $session = $this->getSession($report);
        
        return [
            'title' => $report->title,
            'session' => $session,
            'generated_at' => now()->format('d F Y, H:i'),
            'summary' => $this->getSummary($report),
            'by_program' => $this->getByProgram($report),
            'by_graduation_year' => $this->getByGraduationYear($report),
            'by_status' => $this->getByStatus($report),
            'details' => $this->getDetails($report),
        ];
    }

    /**
     * Get overall summary
     */
    protected function getSummary(Report $report): array
    {
        $alumniQuery = $this->getAlumniQuery($report);
        
        $totalAlumni = $alumniQuery->count();
        
        $responsesQuery = $this->getSurveyResponsesQuery($report);
        
        $totalResponded = $responsesQuery->distinct('survey_responses.alumni_id')->count('survey_responses.alumni_id');
        $totalCompleted = $responsesQuery->where('survey_responses.completion_status', 'completed')->distinct('survey_responses.alumni_id')->count('survey_responses.alumni_id');
        $totalPartial = $responsesQuery->where('survey_responses.completion_status', 'partial')->distinct('survey_responses.alumni_id')->count('survey_responses.alumni_id');
        $totalDraft = $responsesQuery->where('survey_responses.completion_status', 'draft')->distinct('survey_responses.alumni_id')->count('survey_responses.alumni_id');
        $totalNotStarted = $totalAlumni - $totalResponded;

        return [
            'total_alumni' => $totalAlumni,
            'total_responded' => $totalResponded,
            'total_completed' => $totalCompleted,
            'total_partial' => $totalPartial,
            'total_draft' => $totalDraft,
            'total_not_started' => $totalNotStarted,
            'response_rate' => $this->percentage($totalResponded, $totalAlumni),
            'completion_rate' => $this->percentage($totalCompleted, $totalAlumni),
        ];
    }

    /**
     * Get response rate by program
     */
    protected function getByProgram(Report $report): array
    {
        $query = DB::table('alumni')
            ->join('programs', 'alumni.program_id', '=', 'programs.program_id')
            ->join('departments', 'programs.department_id', '=', 'departments.department_id')
            ->leftJoin('survey_responses', function($join) use ($report) {
                $join->on('alumni.alumni_id', '=', 'survey_responses.alumni_id');
                if ($report->session_id) {
                    $join->where('survey_responses.session_id', '=', $report->session_id);
                }
            })
            ->select(
                'programs.program_id',
                'programs.program_name',
                'departments.department_name',
                DB::raw('COUNT(DISTINCT alumni.alumni_id) as total_alumni'),
                DB::raw('COUNT(DISTINCT survey_responses.response_id) as total_responses'),
                DB::raw('COUNT(DISTINCT CASE WHEN survey_responses.completion_status = "completed" THEN survey_responses.response_id END) as total_completed')
            )
            ->groupBy('programs.program_id', 'programs.program_name', 'departments.department_name');

        $params = $report->parameters ?? [];
        
        if (!empty($params['program_ids'])) {
            $query->whereIn('alumni.program_id', $params['program_ids']);
        }

        if (!empty($params['graduation_year_from'])) {
            $query->where('alumni.graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $query->where('alumni.graduation_year', '<=', $params['graduation_year_to']);
        }

        $results = $query->get();

        return $results->map(function($item) {
            return [
                'program_id' => $item->program_id,
                'program_name' => $item->program_name,
                'department_name' => $item->department_name,
                'total_alumni' => $item->total_alumni,
                'total_responses' => $item->total_responses,
                'total_completed' => $item->total_completed,
                'response_rate' => $this->percentage($item->total_responses, $item->total_alumni),
                'completion_rate' => $this->percentage($item->total_completed, $item->total_alumni),
            ];
        })->toArray();
    }

    /**
     * Get response rate by graduation year
     */
    protected function getByGraduationYear(Report $report): array
    {
        $query = DB::table('alumni')
            ->leftJoin('survey_responses', function($join) use ($report) {
                $join->on('alumni.alumni_id', '=', 'survey_responses.alumni_id');
                if ($report->session_id) {
                    $join->where('survey_responses.session_id', '=', $report->session_id);
                }
            })
            ->select(
                'alumni.graduation_year',
                DB::raw('COUNT(DISTINCT alumni.alumni_id) as total_alumni'),
                DB::raw('COUNT(DISTINCT survey_responses.response_id) as total_responses'),
                DB::raw('COUNT(DISTINCT CASE WHEN survey_responses.completion_status = "completed" THEN survey_responses.response_id END) as total_completed')
            )
            ->groupBy('alumni.graduation_year')
            ->orderBy('alumni.graduation_year', 'desc');

        $params = $report->parameters ?? [];
        
        if (!empty($params['program_ids'])) {
            $query->whereIn('alumni.program_id', $params['program_ids']);
        }

        if (!empty($params['graduation_year_from'])) {
            $query->where('alumni.graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $query->where('alumni.graduation_year', '<=', $params['graduation_year_to']);
        }

        $results = $query->get();

        return $results->map(function($item) {
            return [
                'graduation_year' => $item->graduation_year,
                'total_alumni' => $item->total_alumni,
                'total_responses' => $item->total_responses,
                'total_completed' => $item->total_completed,
                'response_rate' => $this->percentage($item->total_responses, $item->total_alumni),
                'completion_rate' => $this->percentage($item->total_completed, $item->total_alumni),
            ];
        })->toArray();
    }

    /**
     * Get distribution by status
     */
    protected function getByStatus(Report $report): array
    {
        $summary = $this->getSummary($report);
        
        return [
            [
                'status' => 'Completed',
                'label' => 'Selesai',
                'count' => $summary['total_completed'],
                'percentage' => $this->percentage($summary['total_completed'], $summary['total_alumni']),
                'color' => '#10b981', // green
            ],
            [
                'status' => 'Partial',
                'label' => 'Dalam Proses',
                'count' => $summary['total_partial'],
                'percentage' => $this->percentage($summary['total_partial'], $summary['total_alumni']),
                'color' => '#f59e0b', // yellow
            ],
            [
                'status' => 'Draft',
                'label' => 'Draft',
                'count' => $summary['total_draft'],
                'percentage' => $this->percentage($summary['total_draft'], $summary['total_alumni']),
                'color' => '#6b7280', // gray
            ],
            [
                'status' => 'Not Started',
                'label' => 'Belum Mulai',
                'count' => $summary['total_not_started'],
                'percentage' => $this->percentage($summary['total_not_started'], $summary['total_alumni']),
                'color' => '#ef4444', // red
            ],
        ];
    }

    /**
     * Get detailed alumni list
     */
    protected function getDetails(Report $report): array
    {
        $query = DB::table('alumni')
            ->join('programs', 'alumni.program_id', '=', 'programs.program_id')
            ->leftJoin('survey_responses', function($join) use ($report) {
                $join->on('alumni.alumni_id', '=', 'survey_responses.alumni_id');
                if ($report->session_id) {
                    $join->where('survey_responses.session_id', '=', $report->session_id);
                }
            })
            ->select(
                'alumni.student_id',
                'alumni.name',
                'programs.program_name',
                'alumni.graduation_year',
                'alumni.email',
                'alumni.phone',
                DB::raw('COALESCE(survey_responses.completion_status, "not_started") as status'),
                'survey_responses.submitted_at'
            )
            ->orderBy('programs.program_name')
            ->orderBy('alumni.name');

        $params = $report->parameters ?? [];
        
        if (!empty($params['program_ids'])) {
            $query->whereIn('alumni.program_id', $params['program_ids']);
        }

        if (!empty($params['graduation_year_from'])) {
            $query->where('alumni.graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $query->where('alumni.graduation_year', '<=', $params['graduation_year_to']);
        }

        return $query->get()->map(function($item) {
            return [
                'student_id' => $item->student_id,
                'name' => $item->name,
                'program_name' => $item->program_name,
                'graduation_year' => $item->graduation_year,
                'email' => $item->email,
                'phone' => $item->phone,
                'status' => $item->status,
                'status_label' => $this->getStatusLabel($item->status),
                'submitted_at' => $item->submitted_at ? \Carbon\Carbon::parse($item->submitted_at)->format('d/m/Y H:i') : '-',
            ];
        })->toArray();
    }

    /**
     * Get status label in Indonesian
     */
    protected function getStatusLabel(string $status): string
    {
        return match($status) {
            'completed' => 'Selesai',
            'partial' => 'Dalam Proses',
            'draft' => 'Draft',
            'not_started' => 'Belum Mulai',
            default => $status,
        };
    }
}
