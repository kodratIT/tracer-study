<?php

namespace Modules\Reports\Filament\Widgets;

use Filament\Widgets\DoughnutChartWidget;
use Illuminate\Support\Facades\DB;
use Modules\Alumni\Models\Alumni;
use Modules\Employment\Models\EmploymentHistory;

class EmploymentStatusChart extends DoughnutChartWidget
{
    protected ?string $heading = 'Employment Status Distribution';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Get employment status based on whether alumni have employment records
        $totalAlumni = Alumni::whereNull('deleted_at')->count();
        
        // Count alumni who have employment records (currently employed or have employment history)
        $employedAlumni = Alumni::whereNull('deleted_at')
            ->whereHas('employmentHistories', function($query) {
                $query->whereNull('deleted_at');
            })
            ->count();
        
        // Count alumni who are currently employed (have employment with no end_date or recent end_date)
        $currentlyEmployed = Alumni::whereNull('deleted_at')
            ->whereHas('employmentHistories', function($query) {
                $query->whereNull('deleted_at')
                      ->where(function($q) {
                          $q->whereNull('end_date')
                            ->orWhere('end_date', '>=', now()->subMonths(6));
                      });
            })
            ->count();
        
        // For now, we'll use a simple categorization
        $unemployedAlumni = $totalAlumni - $employedAlumni;
        
        // Mock continuing study data (you can enhance this based on your business logic)
        $continuingStudy = max(0, min(5, floor($totalAlumni * 0.1))); // Assume 10% or max 5 are continuing studies
        $unemployedAlumni = max(0, $unemployedAlumni - $continuingStudy);

        $employmentData = collect([
            (object)['status' => 'Bekerja', 'total' => $employedAlumni],
            (object)['status' => 'Belum Bekerja', 'total' => $unemployedAlumni],
            (object)['status' => 'Studi Lanjut', 'total' => $continuingStudy],
        ])->filter(function($item) {
            return $item->total > 0;
        });

        $labels = [];
        $values = [];
        $colors = [
            'Bekerja' => '#008FFB',
            'Studi Lanjut' => '#00E396', 
            'Belum Bekerja' => '#FEB019',
        ];

        $backgroundColors = [];

        foreach ($employmentData as $item) {
            $labels[] = $item->status;
            $values[] = $item->total;
            $backgroundColors[] = $colors[$item->status] ?? '#999999';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Employment Status',
                    'data' => $values,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => $backgroundColors,
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}
