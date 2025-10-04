<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Alumni\Models\Alumni;
use Modules\Survey\Models\SurveyResponse;
use Modules\Reports\Models\Report;

class TracerStudyOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalAlumni = Alumni::count();
        $totalResponses = SurveyResponse::count();
        $completedResponses = SurveyResponse::completed()->count();
        $totalReports = Report::count();

        $responseRate = $totalAlumni > 0 ? round(($totalResponses / $totalAlumni) * 100, 1) : 0;
        $completionRate = $totalResponses > 0 ? round(($completedResponses / $totalResponses) * 100, 1) : 0;

        return [
            Stat::make('Total Alumni', number_format($totalAlumni))
                ->description('Alumni terdaftar di sistem')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info')
                ->chart($this->getAlumniTrendData()),

            Stat::make('Response Rate', $responseRate . '%')
                ->description(number_format($totalResponses) . ' dari ' . number_format($totalAlumni) . ' alumni')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($responseRate >= 70 ? 'success' : ($responseRate >= 50 ? 'warning' : 'danger')),

            Stat::make('Completion Rate', $completionRate . '%')
                ->description(number_format($completedResponses) . ' survei selesai')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($completionRate >= 80 ? 'success' : ($completionRate >= 60 ? 'warning' : 'danger')),

            Stat::make('Total Laporan', number_format($totalReports))
                ->description('Laporan yang dihasilkan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
        ];
    }

    protected function getAlumniTrendData(): array
    {
        // Get last 7 days alumni registration count
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $count = Alumni::whereDate('created_at', $date)->count();
            $data[] = $count;
        }
        return $data;
    }
}
