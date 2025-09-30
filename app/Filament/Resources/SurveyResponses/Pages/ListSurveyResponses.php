<?php

namespace App\Filament\Resources\SurveyResponses\Pages;

use App\Filament\Resources\SurveyResponses\SurveyResponseResource;
use Modules\Survey\Models\SurveyResponse;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ListSurveyResponses extends ListRecords
{
    protected static string $resource = SurveyResponseResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            SurveyResponseStatsWidget::class,
        ];
    }
}

class SurveyResponseStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalResponses = SurveyResponse::count();
        $completedResponses = SurveyResponse::completed()->count();
        $partialResponses = SurveyResponse::partial()->count();
        $overdueResponses = SurveyResponse::overdue()->count();
        $activeResponses = SurveyResponse::inActiveSessions()->count();

        $completionRate = $totalResponses > 0 ? round(($completedResponses / $totalResponses) * 100, 1) : 0;

        return [
            Stat::make('Total Respons', number_format($totalResponses))
                ->description('Semua respons yang ada')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),

            Stat::make('Selesai', number_format($completedResponses))
                ->description("Tingkat penyelesaian: {$completionRate}%")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([$partialResponses, $completedResponses]),

            Stat::make('Dalam Proses', number_format($partialResponses))
                ->description('Respons sebagian atau draft')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Aktif', number_format($activeResponses))
                ->description('Dalam sesi aktif')
                ->descriptionIcon('heroicon-m-play')
                ->color('info'),

            Stat::make('Terlambat', number_format($overdueResponses))
                ->description('Sesi berakhir, belum selesai')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }

    protected function getColumns(): int
    {
        return 5;
    }
}
