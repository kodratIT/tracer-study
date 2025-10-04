<?php

namespace App\Services\Reports\Generators;

use Modules\Reports\Models\Report;
use Illuminate\Support\Facades\DB;

class EmploymentStatisticsGenerator extends BaseGenerator
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
            'by_status' => $this->getByEmploymentStatus($report),
            'by_industry' => $this->getByIndustry($report),
            'by_job_level' => $this->getByJobLevel($report),
            'by_contract_type' => $this->getByContractType($report),
        ];
    }

    /**
     * Get overall summary
     */
    protected function getSummary(Report $report): array
    {
        $alumniQuery = $this->getAlumniQuery($report);
        
        $totalAlumni = $alumniQuery->count();
        
        $employmentQuery = DB::table('alumni')
            ->join('employment_histories', 'alumni.alumni_id', '=', 'employment_histories.alumni_id')
            ->where('employment_histories.is_active', true);

        $params = $report->parameters ?? [];
        
        if (!empty($params['program_ids'])) {
            $employmentQuery->whereIn('alumni.program_id', $params['program_ids']);
        }

        if (!empty($params['graduation_year_from'])) {
            $employmentQuery->where('alumni.graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $employmentQuery->where('alumni.graduation_year', '<=', $params['graduation_year_to']);
        }

        $employed = (clone $employmentQuery)->where('employment_histories.employment_status', 'employed')->distinct('alumni.alumni_id')->count('alumni.alumni_id');
        $entrepreneur = (clone $employmentQuery)->where('employment_histories.employment_status', 'entrepreneur')->distinct('alumni.alumni_id')->count('alumni.alumni_id');
        $studying = (clone $employmentQuery)->where('employment_histories.employment_status', 'studying')->distinct('alumni.alumni_id')->count('alumni.alumni_id');
        $unemployed = (clone $employmentQuery)->where('employment_histories.employment_status', 'unemployed')->distinct('alumni.alumni_id')->count('alumni.alumni_id');
        
        $noData = $totalAlumni - ($employed + $entrepreneur + $studying + $unemployed);

        return [
            'total_alumni' => $totalAlumni,
            'employed' => $employed,
            'entrepreneur' => $entrepreneur,
            'studying' => $studying,
            'unemployed' => $unemployed,
            'no_data' => $noData,
            'employment_rate' => $this->percentage($employed + $entrepreneur, $totalAlumni),
        ];
    }

    /**
     * Get employment statistics by program
     */
    protected function getByProgram(Report $report): array
    {
        $query = DB::table('alumni')
            ->join('programs', 'alumni.program_id', '=', 'programs.program_id')
            ->leftJoin('employment_histories', function($join) {
                $join->on('alumni.alumni_id', '=', 'employment_histories.alumni_id')
                     ->where('employment_histories.is_active', '=', true);
            })
            ->select(
                'programs.program_id',
                'programs.program_name',
                DB::raw('COUNT(DISTINCT alumni.alumni_id) as total_alumni'),
                DB::raw('COUNT(DISTINCT CASE WHEN employment_histories.employment_status = "employed" THEN alumni.alumni_id END) as employed'),
                DB::raw('COUNT(DISTINCT CASE WHEN employment_histories.employment_status = "entrepreneur" THEN alumni.alumni_id END) as entrepreneur'),
                DB::raw('COUNT(DISTINCT CASE WHEN employment_histories.employment_status = "studying" THEN alumni.alumni_id END) as studying'),
                DB::raw('COUNT(DISTINCT CASE WHEN employment_histories.employment_status = "unemployed" THEN alumni.alumni_id END) as unemployed')
            )
            ->groupBy('programs.program_id', 'programs.program_name');

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
            $hasEmployment = $item->employed + $item->entrepreneur + $item->studying + $item->unemployed;
            
            return [
                'program_id' => $item->program_id,
                'program_name' => $item->program_name,
                'total_alumni' => $item->total_alumni,
                'employed' => $item->employed,
                'entrepreneur' => $item->entrepreneur,
                'studying' => $item->studying,
                'unemployed' => $item->unemployed,
                'no_data' => $item->total_alumni - $hasEmployment,
                'employment_rate' => $this->percentage($item->employed + $item->entrepreneur, $item->total_alumni),
            ];
        })->toArray();
    }

    /**
     * Get employment statistics by graduation year
     */
    protected function getByGraduationYear(Report $report): array
    {
        $query = DB::table('alumni')
            ->leftJoin('employment_histories', function($join) {
                $join->on('alumni.alumni_id', '=', 'employment_histories.alumni_id')
                     ->where('employment_histories.is_active', '=', true);
            })
            ->select(
                'alumni.graduation_year',
                DB::raw('COUNT(DISTINCT alumni.alumni_id) as total_alumni'),
                DB::raw('COUNT(DISTINCT CASE WHEN employment_histories.employment_status = "employed" THEN alumni.alumni_id END) as employed'),
                DB::raw('COUNT(DISTINCT CASE WHEN employment_histories.employment_status = "entrepreneur" THEN alumni.alumni_id END) as entrepreneur'),
                DB::raw('COUNT(DISTINCT CASE WHEN employment_histories.employment_status = "studying" THEN alumni.alumni_id END) as studying'),
                DB::raw('COUNT(DISTINCT CASE WHEN employment_histories.employment_status = "unemployed" THEN alumni.alumni_id END) as unemployed')
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
            $hasEmployment = $item->employed + $item->entrepreneur + $item->studying + $item->unemployed;
            
            return [
                'graduation_year' => $item->graduation_year,
                'total_alumni' => $item->total_alumni,
                'employed' => $item->employed,
                'entrepreneur' => $item->entrepreneur,
                'studying' => $item->studying,
                'unemployed' => $item->unemployed,
                'no_data' => $item->total_alumni - $hasEmployment,
                'employment_rate' => $this->percentage($item->employed + $item->entrepreneur, $item->total_alumni),
            ];
        })->toArray();
    }

    /**
     * Get distribution by employment status
     */
    protected function getByEmploymentStatus(Report $report): array
    {
        $summary = $this->getSummary($report);
        
        return [
            [
                'status' => 'employed',
                'label' => 'Bekerja',
                'count' => $summary['employed'],
                'percentage' => $this->percentage($summary['employed'], $summary['total_alumni']),
                'color' => '#10b981',
            ],
            [
                'status' => 'entrepreneur',
                'label' => 'Wiraswasta',
                'count' => $summary['entrepreneur'],
                'percentage' => $this->percentage($summary['entrepreneur'], $summary['total_alumni']),
                'color' => '#f59e0b',
            ],
            [
                'status' => 'studying',
                'label' => 'Melanjutkan Studi',
                'count' => $summary['studying'],
                'percentage' => $this->percentage($summary['studying'], $summary['total_alumni']),
                'color' => '#3b82f6',
            ],
            [
                'status' => 'unemployed',
                'label' => 'Tidak Bekerja',
                'count' => $summary['unemployed'],
                'percentage' => $this->percentage($summary['unemployed'], $summary['total_alumni']),
                'color' => '#ef4444',
            ],
            [
                'status' => 'no_data',
                'label' => 'Tidak Ada Data',
                'count' => $summary['no_data'],
                'percentage' => $this->percentage($summary['no_data'], $summary['total_alumni']),
                'color' => '#6b7280',
            ],
        ];
    }

    /**
     * Get distribution by industry type
     */
    protected function getByIndustry(Report $report): array
    {
        $query = DB::table('employment_histories')
            ->join('alumni', 'employment_histories.alumni_id', '=', 'alumni.alumni_id')
            ->join('employers', 'employment_histories.employer_id', '=', 'employers.employer_id')
            ->where('employment_histories.is_active', true)
            ->whereIn('employment_histories.employment_status', ['employed', 'entrepreneur'])
            ->select(
                'employers.industry_type',
                DB::raw('COUNT(DISTINCT employment_histories.employment_id) as total')
            )
            ->groupBy('employers.industry_type')
            ->orderByDesc('total');

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
        $totalCount = $results->sum('total');

        return $results->map(function($item) use ($totalCount) {
            return [
                'industry_type' => $item->industry_type ?? 'Tidak Diketahui',
                'count' => $item->total,
                'percentage' => $this->percentage($item->total, $totalCount),
            ];
        })->toArray();
    }

    /**
     * Get distribution by job level
     */
    protected function getByJobLevel(Report $report): array
    {
        $query = DB::table('employment_histories')
            ->join('alumni', 'employment_histories.alumni_id', '=', 'alumni.alumni_id')
            ->where('employment_histories.is_active', true)
            ->where('employment_histories.employment_status', 'employed')
            ->select(
                'employment_histories.job_level',
                DB::raw('COUNT(DISTINCT employment_histories.employment_id) as total')
            )
            ->groupBy('employment_histories.job_level')
            ->orderByRaw("FIELD(job_level, 'entry', 'junior', 'mid', 'senior', 'lead', 'supervisor', 'manager', 'director', 'vp', 'ceo')");

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
        $totalCount = $results->sum('total');

        $levelLabels = [
            'entry' => 'Entry Level',
            'junior' => 'Junior',
            'mid' => 'Mid Level',
            'senior' => 'Senior',
            'lead' => 'Lead/Team Leader',
            'supervisor' => 'Supervisor',
            'manager' => 'Manager',
            'director' => 'Director',
            'vp' => 'Vice President',
            'ceo' => 'CEO/Founder',
        ];

        return $results->map(function($item) use ($totalCount, $levelLabels) {
            return [
                'job_level' => $item->job_level ?? 'Tidak Diketahui',
                'label' => $levelLabels[$item->job_level] ?? $item->job_level,
                'count' => $item->total,
                'percentage' => $this->percentage($item->total, $totalCount),
            ];
        })->toArray();
    }

    /**
     * Get distribution by contract type
     */
    protected function getByContractType(Report $report): array
    {
        $query = DB::table('employment_histories')
            ->join('alumni', 'employment_histories.alumni_id', '=', 'alumni.alumni_id')
            ->where('employment_histories.is_active', true)
            ->where('employment_histories.employment_status', 'employed')
            ->select(
                'employment_histories.contract_type',
                DB::raw('COUNT(DISTINCT employment_histories.employment_id) as total')
            )
            ->groupBy('employment_histories.contract_type')
            ->orderByDesc('total');

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
        $totalCount = $results->sum('total');

        $contractLabels = [
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'contract' => 'Kontrak',
            'freelance' => 'Freelance',
            'internship' => 'Magang',
        ];

        return $results->map(function($item) use ($totalCount, $contractLabels) {
            return [
                'contract_type' => $item->contract_type ?? 'Tidak Diketahui',
                'label' => $contractLabels[$item->contract_type] ?? $item->contract_type,
                'count' => $item->total,
                'percentage' => $this->percentage($item->total, $totalCount),
            ];
        })->toArray();
    }
}
