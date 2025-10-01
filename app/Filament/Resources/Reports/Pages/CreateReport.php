<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use Filament\Resources\Pages\CreateRecord;
use Modules\Reports\Services\BanPtReportService;
use Filament\Notifications\Notification;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    public function getTitle(): string
    {
        return 'Buat Laporan BAN-PT';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Laporan berhasil dibuat dan akan segera diproses';
    }

    protected function afterCreate(): void
    {
        // Set auto-expiration if enabled
        if ($this->data['parameters']['auto_expire'] ?? true) {
            $this->record->setExpiration(30);
        }
        
        // Queue report generation for background processing
        dispatch(function () {
            $service = app(BanPtReportService::class);
            try {
                $service->generateReport($this->record);
            } catch (\Exception $e) {
                \Log::error('Report generation failed', [
                    'report_id' => $this->record->report_id,
                    'error' => $e->getMessage()
                ]);
                
                $this->record->markAsFailed($e->getMessage());
            }
        })->afterResponse();

        Notification::make()
            ->title('Laporan berhasil dijadwalkan')
            ->body('Laporan Anda telah dijadwalkan untuk dibuat di latar belakang. Refresh halaman untuk melihat progress.')
            ->success()
            ->send();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate auto title if not provided
        if (empty($data['title'])) {
            $type = \Modules\Reports\Models\Report::REPORT_TYPES[$data['report_type']] ?? $data['report_type'];
            $data['title'] = $type . ' - ' . now()->format('d/m/Y H:i');
        }

        // Set default parameters
        $data['parameters'] = array_merge([
            'include_charts' => true,
            'include_raw_data' => false,
            'auto_expire' => true,
        ], $data['parameters'] ?? []);

        return $data;
    }
}
