<?php

namespace App\Filament\Resources\Employments\Pages;

use App\Filament\Resources\Employments\EmploymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Reports\Actions\ExportAction;

class ListEmployments extends ListRecords
{
    protected static string $resource = EmploymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Riwayat Pekerjaan')
                ->icon('heroicon-m-plus'),
            ExportAction::employment()
                ->label('Export Riwayat Pekerjaan'),
        ];
    }
}
