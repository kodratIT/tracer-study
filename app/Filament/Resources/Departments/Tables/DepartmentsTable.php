<?php

namespace App\Filament\Resources\Departments\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;

class DepartmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('department_name')
                    ->label('Nama Jurusan')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->icon('heroicon-m-squares-2x2'),
                    
                TextColumn::make('faculty.faculty_name')
                    ->label('Fakultas')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-academic-cap'),
                    
                TextColumn::make('faculty.campus.campus_name')
                    ->label('Campus')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-building-office-2')
                    ->toggleable(),
                    

                    
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('faculty_id')
                    ->label('Fakultas')
                    ->relationship('faculty', 'faculty_name')
                    ->searchable()
                    ->placeholder('Semua Fakultas'),
            ])
            ->recordActions([

                EditAction::make()->label('Edit')->icon('heroicon-m-pencil-square'),
                DeleteAction::make()->label('Hapus')->icon('heroicon-m-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus Terpilih')->icon('heroicon-m-trash'),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Data Jurusan')
            ->emptyStateDescription('Mulai dengan menambahkan data jurusan pertama.')
            ->emptyStateIcon('heroicon-o-squares-2x2')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultSort('department_name', 'asc');
    }
}
