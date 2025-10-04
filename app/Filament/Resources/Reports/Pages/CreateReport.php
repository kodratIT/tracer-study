<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use Filament\Resources\Pages\CreateRecord;
use App\Services\Reports\ReportGeneratorService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    public function getTitle(): string
    {
        return '📊 Generate Laporan Tracer Study';
    }

    public function getHeading(): string
    {
        return '📊 Generate Laporan Tracer Study';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Laporan berhasil dibuat!';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Laporan berhasil dibuat!')
            ->body('Laporan sedang di-generate. Refresh halaman untuk melihat progress.')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success');
    }

    protected function afterCreate(): void
    {
        // Generate report in background
        dispatch(function () {
            $service = new ReportGeneratorService();
            try {
                Log::info('Starting report generation', [
                    'report_id' => $this->record->report_id,
                    'type' => $this->record->report_type,
                ]);

                $success = $service->generate($this->record);

                if ($success) {
                    Log::info('Report generated successfully', [
                        'report_id' => $this->record->report_id,
                        'file_path' => $this->record->file_path,
                    ]);
                } else {
                    Log::error('Report generation returned false', [
                        'report_id' => $this->record->report_id,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Report generation failed', [
                    'report_id' => $this->record->report_id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        })->afterResponse();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure parameters is array
        if (!isset($data['parameters']) || !is_array($data['parameters'])) {
            $data['parameters'] = [];
        }

        // Set default status
        $data['status'] = 'pending';

        return $data;
    }
}

