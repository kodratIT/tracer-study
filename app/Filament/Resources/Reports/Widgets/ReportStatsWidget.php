<?php

namespace App\Filament\Resources\Reports\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Reports\Models\Report;
use Modules\Survey\Models\SurveyResponse;
use Modules\Alumni\Models\Alumni;

class ReportStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Laporan', Report::count())
                ->description('Jumlah total laporan')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),
                
            Stat::make('Laporan Selesai', Report::where('status', Report::STATUS_COMPLETED)->count())
                ->description('Laporan yang sudah selesai')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
                
            Stat::make('Sedang Proses', Report::where('status', Report::STATUS_GENERATING)->count())
                ->description('Laporan sedang dibuat')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
                
            Stat::make('Total Alumni', Alumni::count())
                ->description('Jumlah data alumni')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('info'),
        ];
    }
}
