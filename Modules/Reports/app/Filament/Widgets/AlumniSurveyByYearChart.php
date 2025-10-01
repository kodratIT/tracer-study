<?php

namespace Modules\Reports\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\DB;
use Modules\Alumni\Models\Alumni;
use Modules\Survey\Models\SurveyResponse;

class AlumniSurveyByYearChart extends BarChartWidget
{
    protected ?string $heading = 'Alumni Survey Response by Graduation Year';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Query alumni who have submitted survey responses, grouped by graduation year
        $data = Alumni::select('graduation_year', DB::raw('count(distinct alumni.alumni_id) as total_alumni'))
            ->join('survey_responses', 'alumni.alumni_id', '=', 'survey_responses.alumni_id')
            ->whereNotNull('graduation_year')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year')
            ->get();

        $labels = [];
        $values = [];

        foreach ($data as $item) {
            $labels[] = (string) $item->graduation_year;
            $values[] = $item->total_alumni;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Alumni Survey Responses',
                    'data' => $values,
                    'backgroundColor' => '#008FFB',
                    'borderColor' => '#008FFB',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Number of Alumni',
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Graduation Year',
                    ],
                ],
            ],
        ];
    }
}
