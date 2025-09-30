<?php

namespace App\Filament\Resources\TracerStudySessions\Pages;

use App\Filament\Resources\TracerStudySessions\TracerStudySessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTracerStudySession extends EditRecord
{
    protected static string $resource = TracerStudySessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus'),
        ];
    }
}
