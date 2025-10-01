<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Modules\Reports\Models\Report;
use Modules\Reports\Services\BanPtReportService;
use Filament\Notifications\Notification;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    public function getTitle(): string
    {
        return 'Detail Laporan: ' . $this->record->title;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn (): bool => in_array($this->record->status, [
                    Report::STATUS_FAILED,
                    Report::STATUS_EXPIRED
                ])),
        ];
    }
}
