<?php

namespace App\Filament\Resources\Campuses\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;

class CampusesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('campus_name')
                    ->label('Nama Campus')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->icon('heroicon-m-building-office-2'),
                    
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->getStateUsing(fn ($record) => $record->city . ', ' . $record->province)
                    ->searchable(['city', 'province'])
                    ->sortable(['city'])
                    ->icon('heroicon-m-map-pin'),
                    
                TextColumn::make('faculties_count')
                    ->label('Fakultas')
                    ->counts('faculties')
                    ->badge()
                    ->color('info')
                    ->alignCenter(),
                    
                TextColumn::make('departments_count')
                    ->label('Jurusan')
                    ->counts('departments')
                    ->badge()
                    ->color('warning')
                    ->alignCenter()
                    ->toggleable(),
                    
                TextColumn::make('programs_count')
                    ->label('Program')
                    ->counts('programs')
                    ->badge()
                    ->color('success')
                    ->alignCenter()
                    ->toggleable(),
                    
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('city')
                    ->label('Kota')
                    ->options(function () {
                        return \Modules\Education\Models\Campus::pluck('city', 'city')
                            ->unique()
                            ->sort();
                    })
                    ->searchable()
                    ->placeholder('Semua Kota'),
                    
                SelectFilter::make('province')
                    ->label('Provinsi')
                    ->options(function () {
                        return \Modules\Education\Models\Campus::pluck('province', 'province')
                            ->unique()
                            ->sort();
                    })
                    ->searchable()
                    ->placeholder('Semua Provinsi'),
            ])
            ->recordActions([

                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-m-pencil-square'),
                DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-m-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->icon('heroicon-m-trash'),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Data Campus')
            ->emptyStateDescription('Mulai dengan menambahkan data campus pertama menggunakan tombol "Tambah Campus".')
            ->emptyStateIcon('heroicon-o-building-office-2')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultSort('campus_name', 'asc');
    }
}
