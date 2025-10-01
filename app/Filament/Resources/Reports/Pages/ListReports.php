<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\CreateAction;
use Modules\Reports\Models\Report;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Laporan Baru')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\Reports\Widgets\ReportStatsWidget::class,
        ];
    }

    public function getTitle(): string
    {
        return 'Laporan BAN-PT';
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-chart-bar';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'Belum ada laporan';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'Buat laporan pertama untuk memulai analisis data tracer study.';
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Laporan')
                ->icon('heroicon-o-plus'),
        ];
    }
}
