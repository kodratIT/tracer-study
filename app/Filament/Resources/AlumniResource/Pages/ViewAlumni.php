<?php

namespace App\Filament\Resources\AlumniResource\Pages;

use App\Filament\Resources\AlumniResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAlumni extends ViewRecord
{
    protected static string $resource = AlumniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Alumni')
                ->icon('heroicon-m-pencil-square'),
            Actions\DeleteAction::make()
                ->label('Hapus Alumni')
                ->icon('heroicon-m-trash'),
        ];
    }

    public function getTitle(): string
    {
        $record = $this->getRecord();
        return "Detail Alumni: {$record->name}";
    }
}
