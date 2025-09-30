<?php

namespace App\Filament\Resources\Programs\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;

class ProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('program_name')
                    ->label('Nama Program Studi')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->icon('heroicon-m-book-open'),
                    
                TextColumn::make('department.department_name')
                    ->label('Jurusan')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-squares-2x2'),
                    
                TextColumn::make('accreditation_status')
                    ->label('Akreditasi')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'A' => '🥇 A',
                        'B' => '🥈 B', 
                        'C' => '🥉 C',
                        'Unggul' => '⭐ Unggul',
                        'Baik Sekali' => '✨ Baik Sekali',
                        'Baik' => '👍 Baik',
                        default => $state
                    })
                    ->color(fn ($state) => match($state) {
                        'A', 'Unggul' => 'success',
                        'B', 'Baik Sekali' => 'warning',
                        'C', 'Baik' => 'danger',
                        default => 'gray'
                    }),
                    
                TextColumn::make('active_years')
                    ->label('Periode Aktif')
                    ->getStateUsing(fn ($record) => $record->active_years)
                    ->icon('heroicon-m-calendar'),
                    
                TextColumn::make('alumni_count')
                    ->label('Alumni')
                    ->counts('alumni')
                    ->badge()
                    ->color('info')
                    ->alignCenter()
                    ->toggleable(),
                    
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('accreditation_status')
                    ->label('Akreditasi')
                    ->options([
                        'A' => '🥇 A (Sangat Baik)',
                        'B' => '🥈 B (Baik)',
                        'C' => '🥉 C (Cukup)',
                        'Unggul' => '⭐ Unggul',
                        'Baik Sekali' => '✨ Baik Sekali',
                        'Baik' => '👍 Baik',
                    ])
                    ->placeholder('Semua Akreditasi'),
                    
                SelectFilter::make('department_id')
                    ->label('Jurusan')
                    ->relationship('department', 'department_name')
                    ->searchable()
                    ->placeholder('Semua Jurusan'),
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
            ->emptyStateHeading('Belum Ada Data Program Studi')
            ->emptyStateDescription('Mulai dengan menambahkan data program studi pertama.')
            ->emptyStateIcon('heroicon-o-book-open')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultSort('program_name', 'asc');
    }
}
