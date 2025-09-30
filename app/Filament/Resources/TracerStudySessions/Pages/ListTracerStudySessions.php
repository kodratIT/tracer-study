<?php

namespace App\Filament\Resources\TracerStudySessions\Pages;

use App\Filament\Resources\TracerStudySessions\TracerStudySessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTracerStudySessions extends ListRecords
{
    protected static string $resource = TracerStudySessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Sesi Baru')
                ->icon('heroicon-m-plus'),
        ];
    }
}
