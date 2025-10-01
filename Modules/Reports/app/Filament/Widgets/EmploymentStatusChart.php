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
        // Get the latest employment status for each alumni
        $employmentData = DB::table('alumni as a')
            ->leftJoin('employment_histories as eh', function($join) {
                $join->on('a.alumni_id', '=', 'eh.alumni_id')
                     ->whereRaw('eh.start_date = (
                         SELECT MAX(start_date) 
                         FROM employment_histories 
                         WHERE alumni_id = a.alumni_id 
                         AND deleted_at IS NULL
                     )')
                     ->whereNull('eh.deleted_at');
            })
            ->select(
                DB::raw('CASE 
                    WHEN eh.employment_status IS NULL THEN "Belum Bekerja"
                    WHEN eh.employment_status = "employed" THEN "Bekerja"
                    WHEN eh.employment_status = "continuing_study" THEN "Studi Lanjut"
                    ELSE "Belum Bekerja"
                END as status'),
                DB::raw('COUNT(a.alumni_id) as total')
            )
            ->whereNull('a.deleted_at')
            ->groupBy('status')
            ->get();

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
