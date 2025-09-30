<?php

namespace App\Filament\Resources\AlumniResource\Pages;

use App\Filament\Resources\AlumniResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateAlumni extends CreateRecord
{
    protected static string $resource = AlumniResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Alumni berhasil ditambahkan!';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Alumni Berhasil Ditambahkan!')
            ->body('Data alumni baru telah berhasil disimpan ke dalam sistem.')
            ->duration(5000);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure graduation year is set if not provided
        if (empty($data['graduation_year'])) {
            $data['graduation_year'] = date('Y');
        }

        return $data;
    }
}
