<?php

namespace App\Filament\Resources\TracerStudySessions\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class TracerStudySessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')
                    ->label('Tahun')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->alignCenter(),
                    
                TextColumn::make('year')
                    ->label('Nama Sesi')
                    ->formatStateUsing(fn ($record) => $record->display_name)
                    ->searchable(['year', 'description'])
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->description 
                        ? (strlen($record->description) > 80 
                            ? substr($record->description, 0, 80) . '...' 
                            : $record->description)
                        : null),
                        
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'upcoming',
                        'success' => 'ongoing',
                        'warning' => 'expired',
                    ])
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'upcoming' => '⏳ Akan Datang',
                            'ongoing' => '▶️ Sedang Berjalan', 
                            'expired' => '✅ Selesai',
                            default => '❓ Tidak Diketahui',
                        };
                    }),
                    
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                    
                TextColumn::make('duration')
                    ->label('Durasi')
                    ->alignCenter()
                    ->formatStateUsing(fn ($state) => $state . ' hari')
                    ->color('info'),
                    
                TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date('d M Y')
                    ->sortable()
                    ->color('success'),
                    
                TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date('d M Y')
                    ->sortable()
                    ->color('warning'),
                    
                // Response statistics columns
                TextColumn::make('total_responses_count')
                    ->label('Total Respons')
                    ->alignCenter()
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => number_format($state))
                    ->toggleable(),
                    
                TextColumn::make('completed_responses_count')
                    ->label('Selesai')
                    ->alignCenter()
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => number_format($state))
                    ->toggleable(),
                    
                TextColumn::make('response_rate')
                    ->label('Tingkat Respons')
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        $state >= 80 => 'success',
                        $state >= 60 => 'warning', 
                        $state >= 40 => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn ($state) => number_format($state, 1) . '%')
                    ->toggleable(),
                    
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('year')
                    ->label('Filter Tahun')
                    ->options(function () {
                        $currentYear = date('Y');
                        $years = [];
                        for ($i = $currentYear + 2; $i >= 2020; $i--) {
                            $years[$i] = $i;
                        }
                        return $years;
                    })
                    ->placeholder('Semua Tahun'),
                    
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'upcoming' => '⏳ Akan Datang',
                        'ongoing' => '▶️ Sedang Berjalan',
                        'expired' => '✅ Selesai',
                    ])
                    ->placeholder('Semua Status')
                    ->query(function (Builder $query, array $data): Builder {
                        if (!$data['value']) {
                            return $query;
                        }
                        
                        $now = now()->toDateString();
                        
                        return match($data['value']) {
                            'upcoming' => $query->where('start_date', '>', $now),
                            'ongoing' => $query->where('start_date', '<=', $now)
                                               ->where('end_date', '>=', $now),
                            'expired' => $query->where('end_date', '<', $now),
                            default => $query,
                        };
                    }),
                    
                SelectFilter::make('is_active')
                    ->label('Filter Aktif')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ])
                    ->placeholder('Semua Status Aktif'),
                    
                Filter::make('date_range')
                    ->label('Filter Rentang Tanggal')
                    ->form([
                        DatePicker::make('start_date_from')
                            ->label('Mulai Dari')
                            ->placeholder('Pilih tanggal mulai')
                            ->columnSpan(1),
                            
                        DatePicker::make('start_date_to')
                            ->label('Sampai')
                            ->placeholder('Pilih tanggal akhir')
                            ->columnSpan(1),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date_from'],
                                fn (Builder $query, $date): Builder => $query->where('start_date', '>=', $date),
                            )
                            ->when(
                                $data['start_date_to'],
                                fn (Builder $query, $date): Builder => $query->where('start_date', '<=', $date),
                            );
                    })
                    ->columns(2),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Dipilih')
                        ->icon('heroicon-m-trash'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->searchPlaceholder('Cari tahun, deskripsi sesi...')
            ->emptyStateHeading('Belum Ada Sesi Tracer Study')
            ->emptyStateDescription('Mulai dengan membuat sesi tracer study pertama untuk mengumpulkan data alumni.')
            ->emptyStateIcon('heroicon-o-clipboard-document-list');
    }
}
