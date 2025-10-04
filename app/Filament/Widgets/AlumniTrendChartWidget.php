<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use Modules\Alumni\Models\Alumni;
use Modules\Survey\Models\SurveyResponse;

class AlumniTrendChartWidget extends LineChartWidget
{
    protected static ?int $sort = 4;
    
    protected int | string | array $columnSpan = 'full';

    public ?string $heading = 'Trend Alumni & Survey';

    protected function getData(): array
    {
        $months = collect();
        $alumniData = [];
        $surveyData = [];
        
        // Get last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->locale('id')->format('M Y');
            $months->push($monthName);
            
            // Count alumni registered in this month
            $alumniCount = Alumni::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $alumniData[] = $alumniCount;
            
            // Count surveys completed in this month
            $surveyCount = SurveyResponse::completed()
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->count();
            $surveyData[] = $surveyCount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Alumni Terdaftar',
                    'data' => $alumniData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Survey Selesai',
                    'data' => $surveyData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'maintainAspectRatio' => true,
            'responsive' => true,
        ];
    }
}
