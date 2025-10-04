<?php

namespace App\Filament\Resources\SurveyResponses\Widgets;

use Modules\Survey\Models\SurveyResponse;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SurveyResponseStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalResponses = SurveyResponse::count();
        $completedResponses = SurveyResponse::completed()->count();
        $partialResponses = SurveyResponse::partial()->count();
        $activeResponses = SurveyResponse::inActiveSessions()->count();

        $completionRate = $totalResponses > 0 ? round(($completedResponses / $totalResponses) * 100, 1) : 0;

        return [
            Stat::make('Survei Selesai', number_format($completedResponses))
                ->description("Completion rate: {$completionRate}%")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart($this->getCompletionTrendData()),

            Stat::make('Dalam Proses', number_format($partialResponses))
                ->description('Belum diselesaikan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Sedang Aktif', number_format($activeResponses))
                ->description('Sedang mengisi survei')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),
        ];
    }

    protected function getCompletionTrendData(): array
    {
        // Get last 7 days completion count
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $count = SurveyResponse::completed()
                ->whereDate('updated_at', $date)
                ->count();
            $data[] = $count;
        }
        return $data;
    }
}
