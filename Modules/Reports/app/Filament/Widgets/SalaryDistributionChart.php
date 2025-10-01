<?php

namespace Modules\Reports\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\DB;
use Modules\Employment\Models\EmploymentHistory;

class SalaryDistributionChart extends BarChartWidget
{
    protected ?string $heading = 'Salary Distribution';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Define salary ranges and their order
        $salaryRanges = [
            '< 3 juta' => ['min' => 0, 'max' => 3000000],
            '3 - 5 juta' => ['min' => 3000000, 'max' => 5000000],
            '5 - 10 juta' => ['min' => 5000000, 'max' => 10000000],
            '> 10 juta' => ['min' => 10000000, 'max' => PHP_INT_MAX],
        ];

        // Get the latest employment for each alumni with salary information
        $employmentData = DB::table('employment_histories as eh1')
            ->join('alumni as a', 'eh1.alumni_id', '=', 'a.alumni_id')
            ->whereRaw('eh1.start_date = (
                SELECT MAX(start_date) 
                FROM employment_histories eh2 
                WHERE eh2.alumni_id = eh1.alumni_id 
                AND eh2.deleted_at IS NULL
            )')
            ->whereNotNull('eh1.salary_range')
            ->whereNull('eh1.deleted_at')
            ->whereNull('a.deleted_at')
            ->select('salary_range')
            ->get();

        // Initialize counters for each range
        $rangeCounts = array_fill_keys(array_keys($salaryRanges), 0);

        foreach ($employmentData as $employment) {
            $salaryRange = $employment->salary_range;
            
            // Map salary_range to our predefined ranges
            // Assuming salary_range contains numeric values or range strings
            if (is_numeric($salaryRange)) {
                $salary = (int) $salaryRange;
                foreach ($salaryRanges as $rangeName => $range) {
                    if ($salary >= $range['min'] && $salary < $range['max']) {
                        $rangeCounts[$rangeName]++;
                        break;
                    }
                }
            } else {
                // Handle string-based salary ranges
                $salaryLower = strtolower($salaryRange);
                if (str_contains($salaryLower, '< 3') || str_contains($salaryLower, 'kurang dari 3')) {
                    $rangeCounts['< 3 juta']++;
                } elseif (str_contains($salaryLower, '3') && str_contains($salaryLower, '5')) {
                    $rangeCounts['3 - 5 juta']++;
                } elseif (str_contains($salaryLower, '5') && str_contains($salaryLower, '10')) {
                    $rangeCounts['5 - 10 juta']++;
                } elseif (str_contains($salaryLower, '> 10') || str_contains($salaryLower, 'lebih dari 10')) {
                    $rangeCounts['> 10 juta']++;
                }
            }
        }

        $labels = array_keys($rangeCounts);
        $values = array_values($rangeCounts);

        // Generate gradient blue to green colors
        $colors = [
            '#008FFB', // Blue
            '#00B4D8', // Light Blue
            '#00C896', // Blue-Green
            '#00E396', // Green
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Alumni Count',
                    'data' => $values,
                    'backgroundColor' => $colors,
                    'borderColor' => $colors,
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'horizontalBar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Number of Alumni',
                    ],
                ],
                'y' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Salary Range',
                    ],
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}
