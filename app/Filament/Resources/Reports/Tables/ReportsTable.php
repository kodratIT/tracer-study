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
use Modules\Reports\Services\BanPtReportService;
use Filament\Notifications\Notification;

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
                    ->tooltip(fn (TextColumn $column): ?string => strlen($column->getState()) > 50 ? $column->getState() : null),

                BadgeColumn::make('report_type')
                    ->label('Jenis')
                    ->formatStateUsing(fn ($state) => Report::REPORT_TYPES[$state] ?? $state)
                    ->colors([
                        'primary' => 'employment_statistics',
                        'success' => 'ban_pt_standard',
                        'warning' => 'waiting_period',
                        'info' => 'job_relevance',
                        'secondary' => 'salary_analysis',
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

                IconColumn::make('file_exists')
                    ->label('File')
                    ->boolean()
                    ->trueIcon('heroicon-o-document')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('generated_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->placeholder('Belum dibuat'),

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
                    ->options(TracerStudySession::all()->pluck('display_name', 'session_id'))
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
                // ✅ Custom: Generate report
                Action::make('generate')
                    ->label('Generate')
                    ->icon('heroicon-s-play')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === Report::STATUS_PENDING)
                    ->requiresConfirmation()
                    ->modalHeading('Generate Laporan')
                    ->modalDescription('Apakah Anda yakin ingin menggenerate laporan ini?')
                    ->action(function ($record) {
                        try {
                            app(BanPtReportService::class)->generateReport($record);

                            Notification::make()
                                ->title('Laporan berhasil digenerate')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal generate laporan')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // ✅ Custom: Download report
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-s-arrow-down-tray')
                    ->color('primary')
                    ->visible(fn ($record) => $record->status === Report::STATUS_COMPLETED && $record->file_exists)
                    ->url(fn ($record) => $record->download_url)
                    ->openUrlInNewTab(),

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
