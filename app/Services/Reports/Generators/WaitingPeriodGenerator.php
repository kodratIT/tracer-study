<?php

namespace App\Services\Reports\Generators;

use Modules\Reports\Models\Report;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WaitingPeriodGenerator extends BaseGenerator
{
    public function generate(Report $report): array
    {
        $session = $this->getSession($report);
        
        return [
            'title' => $report->title,
            'session' => $session,
            'generated_at' => now()->format('d F Y, H:i'),
            'summary' => $this->getSummary($report),
            'distribution' => $this->getDistribution($report),
            'by_program' => $this->getByProgram($report),
            'by_graduation_year' => $this->getByGraduationYear($report),
            'details' => $this->getDetails($report),
        ];
    }

    /**
     * Get overall summary
     */
    protected function getSummary(Report $report): array
    {
        $waitingPeriods = $this->getWaitingPeriods($report);
        
        if (empty($waitingPeriods)) {
            return [
                'total_alumni' => 0,
                'with_data' => 0,
                'average_months' => 0,
                'median_months' => 0,
                'min_months' => 0,
                'max_months' => 0,
            ];
        }

        $periods = collect($waitingPeriods)->pluck('waiting_months')->filter();
        
        return [
            'total_alumni' => count($waitingPeriods),
            'with_data' => $periods->count(),
            'average_months' => $periods->count() > 0 ? round($periods->avg(), 2) : 0,
            'median_months' => $periods->count() > 0 ? $periods->median() : 0,
            'min_months' => $periods->count() > 0 ? $periods->min() : 0,
            'max_months' => $periods->count() > 0 ? $periods->max() : 0,
        ];
    }

    /**
     * Get distribution by waiting period ranges
     */
    protected function getDistribution(Report $report): array
    {
        $waitingPeriods = $this->getWaitingPeriods($report);
        
        $ranges = [
            '<3' => ['label' => 'Kurang dari 3 bulan', 'count' => 0, 'color' => '#10b981'],
            '3-6' => ['label' => '3-6 bulan', 'count' => 0, 'color' => '#3b82f6'],
            '6-12' => ['label' => '6-12 bulan', 'count' => 0, 'color' => '#f59e0b'],
            '>12' => ['label' => 'Lebih dari 12 bulan', 'count' => 0, 'color' => '#ef4444'],
            'no_data' => ['label' => 'Tidak ada data', 'count' => 0, 'color' => '#6b7280'],
        ];

        $total = count($waitingPeriods);
        
        foreach ($waitingPeriods as $item) {
            if ($item['waiting_months'] === null) {
                $ranges['no_data']['count']++;
            } elseif ($item['waiting_months'] < 3) {
                $ranges['<3']['count']++;
            } elseif ($item['waiting_months'] < 6) {
                $ranges['3-6']['count']++;
            } elseif ($item['waiting_months'] < 12) {
                $ranges['6-12']['count']++;
            } else {
                $ranges['>12']['count']++;
            }
        }

        return array_map(function($range) use ($total) {
            $range['percentage'] = $this->percentage($range['count'], $total);
            return $range;
        }, $ranges);
    }

    /**
     * Get waiting period by program
     */
    protected function getByProgram(Report $report): array
    {
        $waitingPeriods = $this->getWaitingPeriods($report);
        
        $byProgram = collect($waitingPeriods)->groupBy('program_id');
        
        return $byProgram->map(function($items, $programId) {
            $periods = $items->pluck('waiting_months')->filter();
            
            return [
                'program_id' => $programId,
                'program_name' => $items->first()['program_name'],
                'total_alumni' => $items->count(),
                'with_data' => $periods->count(),
                'average_months' => $periods->count() > 0 ? round($periods->avg(), 2) : 0,
                'median_months' => $periods->count() > 0 ? $periods->median() : 0,
                'less_than_3_months' => $items->filter(fn($i) => $i['waiting_months'] !== null && $i['waiting_months'] < 3)->count(),
            ];
        })->values()->toArray();
    }

    /**
     * Get waiting period by graduation year
     */
    protected function getByGraduationYear(Report $report): array
    {
        $waitingPeriods = $this->getWaitingPeriods($report);
        
        $byYear = collect($waitingPeriods)->groupBy('graduation_year');
        
        return $byYear->map(function($items, $year) {
            $periods = $items->pluck('waiting_months')->filter();
            
            return [
                'graduation_year' => $year,
                'total_alumni' => $items->count(),
                'with_data' => $periods->count(),
                'average_months' => $periods->count() > 0 ? round($periods->avg(), 2) : 0,
                'median_months' => $periods->count() > 0 ? $periods->median() : 0,
            ];
        })->sortByDesc('graduation_year')->values()->toArray();
    }

    /**
     * Get waiting periods for all alumni
     * 
     * Waiting period = time between graduation and first employment
     */
    protected function getWaitingPeriods(Report $report): array
    {
        $query = DB::table('alumni')
            ->join('programs', 'alumni.program_id', '=', 'programs.program_id')
            ->leftJoin('employment_histories', function($join) {
                $join->on('alumni.alumni_id', '=', 'employment_histories.alumni_id')
                     ->where('employment_histories.is_active', '=', true)
                     ->where('employment_histories.employment_status', '=', 'employed');
            })
            ->select(
                'alumni.alumni_id',
                'alumni.student_id',
                'alumni.name',
                'alumni.email',
                'programs.program_id',
                'programs.program_name',
                'alumni.graduation_year',
                'alumni.graduation_date',
                'employment_histories.created_at as employment_date'
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

        $results = $query->get();

        return $results->map(function($item) {
            $waitingMonths = null;
            $waitingDays = null;
            
            if ($item->graduation_date && $item->employment_date) {
                $graduationDate = Carbon::parse($item->graduation_date);
                $employmentDate = Carbon::parse($item->employment_date);
                
                $waitingDays = $graduationDate->diffInDays($employmentDate);
                $waitingMonths = round($waitingDays / 30, 1);
                
                // Negative means employed before graduation (internship converted to full-time)
                if ($waitingMonths < 0) {
                    $waitingMonths = 0;
                }
            }

            return [
                'alumni_id' => $item->alumni_id,
                'student_id' => $item->student_id,
                'name' => $item->name,
                'email' => $item->email,
                'program_id' => $item->program_id,
                'program_name' => $item->program_name,
                'graduation_year' => $item->graduation_year,
                'graduation_date' => $item->graduation_date,
                'employment_date' => $item->employment_date,
                'waiting_months' => $waitingMonths,
                'waiting_days' => $waitingDays,
                'waiting_label' => $this->getWaitingLabel($waitingMonths),
            ];
        })->toArray();
    }

    /**
     * Get waiting period label
     */
    protected function getWaitingLabel($months): string
    {
        if ($months === null) {
            return 'Tidak ada data';
        }
        
        if ($months == 0) {
            return 'Langsung bekerja';
        }
        
        if ($months < 1) {
            return 'Kurang dari 1 bulan';
        }
        
        if ($months < 3) {
            return 'Kurang dari 3 bulan';
        }
        
        if ($months < 6) {
            return '3-6 bulan';
        }
        
        if ($months < 12) {
            return '6-12 bulan';
        }
        
        return 'Lebih dari 12 bulan';
    }
}
