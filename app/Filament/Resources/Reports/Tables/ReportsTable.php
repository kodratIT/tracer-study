<?php

namespace App\Filament\Resources\Reports\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;    // ⬅️ bawaan table
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Reports\Models\Report;
use Modules\Survey\Models\TracerStudySession;
use App\Services\Reports\ReportGeneratorService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Laporan')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->icon(fn ($record) => match($record->report_type) {
                        'response_rate' => 'heroicon-o-chart-bar',
                        'employment_statistics' => 'heroicon-o-briefcase',
                        'waiting_period' => 'heroicon-o-clock',
                        'job_relevance' => 'heroicon-o-academic-cap',
                        'salary_analysis' => 'heroicon-o-currency-dollar',
                        'competency_analysis' => 'heroicon-o-light-bulb',
                        'geographic_distribution' => 'heroicon-o-map',
                        'ban_pt_standard' => 'heroicon-o-document-text',
                        default => 'heroicon-o-document',
                    })
                    ->weight('medium')
                    ->tooltip(fn (TextColumn $column): ?string => strlen($column->getState()) > 50 ? $column->getState() : null),

                BadgeColumn::make('report_type')
                    ->label('Jenis')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'response_rate' => 'Response Rate',
                        'employment_statistics' => 'Employment',
                        'waiting_period' => 'Waiting Period',
                        'job_relevance' => 'Job Relevance',
                        'salary_analysis' => 'Salary',
                        'competency_analysis' => 'Competency',
                        'geographic_distribution' => 'Geographic',
                        'ban_pt_standard' => 'BAN-PT',
                        default => $state,
                    })
                    ->colors([
                        'primary' => 'employment_statistics',
                        'success' => 'ban_pt_standard',
                        'warning' => 'waiting_period',
                        'info' => 'job_relevance',
                        'secondary' => 'salary_analysis',
                        'danger' => 'response_rate',
                    ]),

                TextColumn::make('session.display_name')
                    ->label('Sesi')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->default('Semua Sesi'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => match($state) {
                        Report::STATUS_COMPLETED => 'Selesai',
                        Report::STATUS_GENERATING => 'Sedang Dibuat',
                        Report::STATUS_PENDING => 'Menunggu',
                        Report::STATUS_FAILED => 'Gagal',
                        Report::STATUS_EXPIRED => 'Kedaluwarsa',
                        default => 'Tidak Diketahui',
                    })
                    ->colors([
                        'success' => Report::STATUS_COMPLETED,
                        'warning' => Report::STATUS_GENERATING,
                        'secondary' => Report::STATUS_PENDING,
                        'danger' => Report::STATUS_FAILED,
                        'gray' => Report::STATUS_EXPIRED,
                    ])
                    ->sortable(),

                TextColumn::make('file_format')
                    ->label('Format')
                    ->badge()
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->colors([
                        'danger' => Report::FORMAT_PDF,
                        'success' => Report::FORMAT_EXCEL,
                        'info' => Report::FORMAT_CSV,
                    ]),

                TextColumn::make('file_size')
                    ->label('Ukuran File')
                    ->state(function ($record) {
                        if (!$record->file_path || !Storage::exists($record->file_path)) {
                            return '-';
                        }
                        
                        $bytes = Storage::size($record->file_path);
                        $units = ['B', 'KB', 'MB', 'GB'];
                        
                        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
                            $bytes /= 1024;
                        }
                        
                        return round($bytes, 2) . ' ' . $units[$i];
                    })
                    ->badge()
                    ->color('gray'),

                TextColumn::make('generated_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->placeholder('Belum dibuat')
                    ->description(fn ($record) => $record->generated_at ? $record->generated_at->diffForHumans() : null),

                TextColumn::make('created_at')
                    ->label('Permintaan')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('expires_at')
                    ->label('Kedaluwarsa')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Tidak pernah')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('report_type')
                    ->label('Jenis Laporan')
                    ->options(Report::REPORT_TYPES)
                    ->placeholder('Semua jenis'),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        Report::STATUS_COMPLETED => 'Selesai',
                        Report::STATUS_GENERATING => 'Sedang Dibuat',
                        Report::STATUS_PENDING => 'Menunggu',
                        Report::STATUS_FAILED => 'Gagal',
                        Report::STATUS_EXPIRED => 'Kedaluwarsa',
                    ])
                    ->placeholder('Semua status'),

                SelectFilter::make('session_id')
                    ->label('Sesi Tracer Study')
                    ->options(function () {
                        return Cache::remember('reports_table_sessions_filter', 300, function () {
                            return TracerStudySession::select('session_id', 'year', 'start_date', 'end_date')
                                ->orderBy('year', 'desc')
                                ->get()
                                ->mapWithKeys(function ($session) {
                                    $displayName = "Tracer Study {$session->year} ({$session->start_date->format('M d')} - {$session->end_date->format('M d')})";
                                    return [$session->session_id => $displayName];
                                });
                        });
                    })
                    ->placeholder('Semua sesi'),

                SelectFilter::make('file_format')
                    ->label('Format File')
                    ->options([
                        Report::FORMAT_PDF => 'PDF',
                        Report::FORMAT_EXCEL => 'Excel',
                        Report::FORMAT_CSV => 'CSV',
                    ])
                    ->placeholder('Semua format'),

                Filter::make('generated_today')
                    ->label('Dibuat Hari Ini')
                    ->query(fn (Builder $query): Builder => $query->whereDate('generated_at', today())),

                Filter::make('expired')
                    ->label('Kedaluwarsa')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '<', now())),

                Filter::make('has_file')
                    ->label('Memiliki File')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('file_path')),
            ])
            ->recordActions([
                // ✅ Custom: Download report
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-s-arrow-down-tray')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === Report::STATUS_COMPLETED && $record->file_path)
                    ->action(function ($record) {
                        if (!$record->file_path || !Storage::exists($record->file_path)) {
                            Notification::make()
                                ->title('File tidak ditemukan')
                                ->body('File laporan tidak ada atau sudah dihapus.')
                                ->danger()
                                ->send();
                            return;
                        }
                        
                        return response()->download(
                            Storage::path($record->file_path),
                            basename($record->file_path)
                        );
                    }),
                
                // ✅ Custom: Regenerate report
                Action::make('regenerate')
                    ->label('Regenerate')
                    ->icon('heroicon-s-arrow-path')
                    ->color('warning')
                    ->visible(fn ($record) => in_array($record->status, [Report::STATUS_COMPLETED, Report::STATUS_FAILED]))
                    ->requiresConfirmation()
                    ->modalHeading('Regenerate Laporan')
                    ->modalDescription('Apakah Anda yakin ingin regenerate laporan ini? File lama akan ditimpa.')
                    ->action(function ($record) {
                        try {
                            // Reset status
                            $record->update(['status' => Report::STATUS_PENDING]);
                            
                            // Generate in background
                            dispatch(function () use ($record) {
                                $service = new ReportGeneratorService();
                                $service->generate($record);
                            })->afterResponse();

                            Notification::make()
                                ->title('Laporan dijadwalkan untuk regenerate')
                                ->body('Refresh halaman untuk melihat progress.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal regenerate laporan')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // ✅ Bawaan
                ViewAction::make()
                    ->label('Lihat Detail')
                    ->icon('heroicon-m-eye'),

                DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-m-trash')
                    ->visible(fn (Report $record): bool => in_array($record->status, [
                        Report::STATUS_FAILED,
                        Report::STATUS_EXPIRED,
                    ])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->icon('heroicon-m-trash'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s')
            ->striped()
            ->persistFiltersInSession()
            ->persistSortInSession()
            ->persistSearchInSession();
    }
}
