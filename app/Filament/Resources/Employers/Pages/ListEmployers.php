<?php

namespace App\Filament\Resources\Employers\Pages;

use App\Filament\Resources\Employers\EmployerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployers extends ListRecords
{
    protected static string $resource = EmployerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Perusahaan')
                ->icon('heroicon-m-plus'),
        ];
    }
}
