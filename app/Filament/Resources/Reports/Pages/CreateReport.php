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
        // Automatically start report generation after creation
        try {
            $service = app(BanPtReportService::class);
            
            // Set auto-expiration if enabled
            if ($this->data['parameters']['auto_expire'] ?? true) {
                $this->record->setExpiration(30);
            }
            
            // Start report generation in background
            dispatch(function () use ($service) {
                $service->generateReport($this->record);
            })->afterResponse();

            Notification::make()
                ->title('Laporan sedang diproses')
                ->body('Laporan Anda sedang dibuat di latar belakang. Anda akan mendapat notifikasi setelah selesai.')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal memproses laporan')
                ->body('Laporan berhasil dibuat tetapi gagal diproses: ' . $e->getMessage())
                ->warning()
                ->send();
        }
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
