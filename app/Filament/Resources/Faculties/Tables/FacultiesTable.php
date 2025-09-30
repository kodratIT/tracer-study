<?php

namespace App\Filament\Resources\Faculties\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;

class FacultiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('faculty_name')
                    ->label('Nama Fakultas')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->icon('heroicon-m-academic-cap'),
                    
                TextColumn::make('campus.campus_name')
                    ->label('Campus')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-building-office-2'),
                    
                TextColumn::make('campus.location')
                    ->label('Lokasi Campus')
                    ->getStateUsing(fn ($record) => $record->campus ? $record->campus->city . ', ' . $record->campus->province : '-')
                    ->searchable(['campus.city', 'campus.province'])
                    ->icon('heroicon-m-map-pin')
                    ->toggleable(),
                    
                TextColumn::make('departments_count')
                    ->label('Jurusan')
                    ->counts('departments')
                    ->badge()
                    ->color('warning')
                    ->alignCenter(),
                    
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
                SelectFilter::make('campus_id')
                    ->label('Campus')
                    ->relationship('campus', 'campus_name')
                    ->searchable()
                    ->placeholder('Semua Campus')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->campus_name . ' (' . $record->city . ')'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-m-eye'),
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
            ->emptyStateHeading('Belum Ada Data Fakultas')
            ->emptyStateDescription('Mulai dengan menambahkan data fakultas pertama menggunakan tombol "Tambah Fakultas".')
            ->emptyStateIcon('heroicon-o-academic-cap')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultSort('faculty_name', 'asc');
    }
}
