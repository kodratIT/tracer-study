<?php

namespace App\Filament\Resources\AlumniResource\Pages;

use App\Filament\Resources\AlumniResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAlumni extends ListRecords
{
    protected static string $resource = AlumniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Alumni')
                ->icon('heroicon-m-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Alumni')
                ->icon('heroicon-m-user-group'),
                
            'recent' => Tab::make('Alumni Terbaru')
                ->icon('heroicon-m-sparkles')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at', '>=', now()->subMonth())),
                
            'high_gpa' => Tab::make('IPK Tinggi (≥3.5)')
                ->icon('heroicon-m-star')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('gpa', '>=', 3.5)),
                
            'employed' => Tab::make('Sudah Bekerja')
                ->icon('heroicon-m-briefcase')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('employmentHistories')),
                
            'male' => Tab::make('Laki-laki')
                ->icon('heroicon-m-user')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('gender', 'male')),
                
            'female' => Tab::make('Perempuan')
                ->icon('heroicon-m-user')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('gender', 'female')),
        ];
    }
}
