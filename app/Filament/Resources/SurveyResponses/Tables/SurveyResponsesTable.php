<?php

namespace App\Filament\Resources\SurveyResponses\Tables;

use Modules\Survey\Models\SurveyResponse;
use Modules\Survey\Models\TracerStudySession;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action;

class SurveyResponsesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('progress_icon')
                    ->label('Status')
                    ->icon(fn ($record) => $record->progress_icon)
                    ->color(fn ($record) => $record->status_color)
                    ->alignCenter()
                    ->tooltip(fn ($record) => 'Status: ' . $record->status_label),
                    
                TextColumn::make('alumni.name')
                    ->label('Nama Alumni')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => 
                        'NIM: ' . $record->alumni?->student_id . 
                        ' | Angkatan: ' . $record->alumni?->graduation_year
                    )
                    ->wrap(),
                    
                TextColumn::make('session.display_name')
                    ->label('Sesi Survey')
                    ->searchable(['year'])
                    ->sortable()
                    ->limit(25)
                    ->tooltip(fn ($record) => $record->session?->display_name)
                    ->description(fn ($record) => 
                        $record->session ? 
                        $record->session->start_date->format('d M Y') . ' - ' . $record->session->end_date->format('d M Y') :
                        null
                    ),
                    
                TextColumn::make('status_label')
                    ->label('Status Respons')
                    ->badge()
                    ->color(fn ($record) => match($record->completion_status) {
                        'completed' => 'success',
                        'partial' => 'warning',
                        'draft' => 'secondary',
                        default => 'gray',
                    })
                    ->icon(fn ($record) => match($record->completion_status) {
                        'completed' => 'heroicon-o-check-circle',
                        'partial' => 'heroicon-o-clock',
                        'draft' => 'heroicon-o-pencil-square',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->sortable('completion_status'),
                    
                TextColumn::make('completion_percentage')
                    ->label('Progress')
                    ->formatStateUsing(function ($record) {
                        $percentage = $record->completion_percentage;
                        $color = match (true) {
                            $percentage >= 100 => 'success',
                            $percentage >= 70 => 'warning', 
                            $percentage >= 40 => 'primary',
                            default => 'gray',
                        };
                        
                        // Create a simple progress display
                        $bars = str_repeat('█', intval($percentage / 10));
                        $empty = str_repeat('░', 10 - intval($percentage / 10));
                        return $bars . $empty . " {$percentage}%";
                    })
                    ->color(fn ($record) => match (true) {
                        $record->completion_percentage >= 100 => 'success',
                        $record->completion_percentage >= 70 => 'warning',
                        $record->completion_percentage >= 40 => 'primary', 
                        default => 'gray',
                    })
                    ->alignCenter()
                    ->fontFamily('mono'),
                    
                IconColumn::make('is_overdue')
                    ->label('Terlambat')
                    ->boolean()
                    ->alignCenter()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-check')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->tooltip(fn ($record) => 
                        $record->is_overdue ? 
                        'Sesi telah berakhir tetapi belum selesai' : 
                        'Masih dalam periode atau sudah selesai'
                    )
                    ->toggleable(),
                    
                TextColumn::make('time_since')
                    ->label('Waktu')
                    ->sortable(['submitted_at', 'updated_at'])
                    ->description(function ($record) {
                        if ($record->response_duration && $record->submitted_at) {
                            $duration = $record->response_duration;
                            if ($duration > 60) {
                                $hours = intval($duration / 60);
                                $minutes = $duration % 60;
                                return "Durasi: {$hours}j {$minutes}m";
                            }
                            return "Durasi: {$duration}m";
                        }
                        return null;
                    })
                    ->color(fn ($record) => $record->submitted_at ? 'success' : 'secondary')
                    ->toggleable(),
                    
                TextColumn::make('alumni.graduation_year')
                    ->label('Angkatan')
                    ->alignCenter()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('created_at')
                    ->label('Dimulai')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->description(fn ($record) => 'ID: ' . $record->response_id)
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('submitted_at')
                    ->label('Diserahkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->placeholder('Belum diserahkan')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('session_id')
                    ->label('Filter Sesi')
                    ->options(function () {
                        return TracerStudySession::query()
                            ->orderBy('year', 'desc')
                            ->get()
                            ->pluck('display_name', 'session_id')
                            ->toArray();
                    })
                    ->placeholder('Semua Sesi')
                    ->preload(),
                    
                SelectFilter::make('completion_status')
                    ->label('Status Pengisian')
                    ->options([
                        'completed' => '✅ Selesai',
                        'partial' => '⏳ Sebagian',
                        'draft' => '✏️ Draft',
                    ])
                    ->placeholder('Semua Status'),
                    
                SelectFilter::make('graduation_year')
                    ->label('Filter Angkatan')
                    ->options(function () {
                        $currentYear = date('Y');
                        $years = [];
                        for ($i = $currentYear; $i >= 2010; $i--) {
                            $years[$i] = "Angkatan $i";
                        }
                        return $years;
                    })
                    ->placeholder('Semua Angkatan')
                    ->query(function (Builder $query, array $data): Builder {
                        if (!$data['value']) {
                            return $query;
                        }
                        
                        return $query->whereHas('alumni', function ($q) use ($data) {
                            $q->where('graduation_year', $data['value']);
                        });
                    }),
                    
                Filter::make('is_overdue')
                    ->label('Filter Keterlambatan')
                    ->form([
                        Select::make('overdue_status')
                            ->label('Status Keterlambatan')
                            ->options([
                                'overdue' => '⚠️ Terlambat (sesi berakhir, belum selesai)',
                                'active' => '🔄 Dalam periode aktif',
                                'completed_on_time' => '✅ Selesai tepat waktu',
                            ])
                            ->placeholder('Semua Status')
                            ->columnSpan(1),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!isset($data['overdue_status'])) {
                            return $query;
                        }
                        
                        switch ($data['overdue_status']) {
                            case 'overdue':
                                return $query->overdue();
                                
                            case 'active':
                                return $query->inActiveSessions()
                                           ->where('completion_status', '!=', 'completed');
                                           
                            case 'completed_on_time':
                                return $query->where('completion_status', 'completed')
                                           ->whereHas('session', function ($q) {
                                               $q->where('end_date', '>=', now());
                                           });
                        }
                        
                        return $query;
                    })
                    ->columns(1),
                    
                Filter::make('submission_date')
                    ->label('Filter Tanggal Pengiriman')
                    ->form([
                        DatePicker::make('submitted_from')
                            ->label('Dari Tanggal')
                            ->placeholder('Pilih tanggal mulai')
                            ->columnSpan(1),
                            
                        DatePicker::make('submitted_until')
                            ->label('Sampai Tanggal')
                            ->placeholder('Pilih tanggal akhir')
                            ->columnSpan(1),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['submitted_from'],
                                fn (Builder $query, $date): Builder => $query->where('submitted_at', '>=', $date),
                            )
                            ->when(
                                $data['submitted_until'],
                                fn (Builder $query, $date): Builder => $query->where('submitted_at', '<=', $date),
                            );
                    })
                    ->columns(2),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('Detail')
                    ->icon('heroicon-m-eye')
                    ->modalHeading(fn ($record) => 'Detail Respons: ' . $record->alumni?->name)
                    ->modalContent(function ($record) {
                        $content = '<div style="space-y-6">';
                        
                        // Alumni Information
                        $content .= '<div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; background: #f9fafb;">';
                        $content .= '<h4 style="font-weight: bold; color: #374151; margin-bottom: 12px;">👤 Informasi Alumni</h4>';
                        $content .= '<div style="grid-template-columns: repeat(2, 1fr); display: grid; gap: 8px;">';
                        $content .= '<div><strong>Nama:</strong> ' . ($record->alumni?->name ?? 'N/A') . '</div>';
                        $content .= '<div><strong>NIM:</strong> ' . ($record->alumni?->student_id ?? 'N/A') . '</div>';
                        $content .= '<div><strong>Angkatan:</strong> ' . ($record->alumni?->graduation_year ?? 'N/A') . '</div>';
                        $content .= '<div><strong>Email:</strong> ' . ($record->alumni?->email ?? 'N/A') . '</div>';
                        $content .= '</div>';
                        $content .= '</div>';
                        
                        // Session Information
                        $content .= '<div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; background: white; margin-top: 16px;">';
                        $content .= '<h4 style="font-weight: bold; color: #374151; margin-bottom: 12px;">📊 Informasi Sesi</h4>';
                        $content .= '<div style="grid-template-columns: repeat(2, 1fr); display: grid; gap: 8px;">';
                        $content .= '<div><strong>Nama Sesi:</strong> ' . ($record->session?->display_name ?? 'N/A') . '</div>';
                        $content .= '<div><strong>Tahun:</strong> ' . ($record->session?->year ?? 'N/A') . '</div>';
                        if ($record->session) {
                            $content .= '<div><strong>Periode:</strong> ' . $record->session->start_date->format('d M Y') . ' - ' . $record->session->end_date->format('d M Y') . '</div>';
                            $content .= '<div><strong>Status Sesi:</strong> ' . match($record->session->status) {
                                'upcoming' => '⏳ Akan Datang',
                                'ongoing' => '▶️ Sedang Berjalan',
                                'expired' => '✅ Selesai',
                                default => '❓ Tidak Diketahui',
                            } . '</div>';
                        }
                        $content .= '</div>';
                        $content .= '</div>';
                        
                        // Response Status
                        $statusColor = match($record->completion_status) {
                            'completed' => '#10b981',
                            'partial' => '#f59e0b',
                            'draft' => '#6b7280',
                            default => '#ef4444',
                        };
                        
                        $content .= '<div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; background: white; margin-top: 16px;">';
                        $content .= '<h4 style="font-weight: bold; color: #374151; margin-bottom: 12px;">📝 Status Respons</h4>';
                        $content .= '<div style="grid-template-columns: repeat(2, 1fr); display: grid; gap: 8px;">';
                        $content .= '<div><strong>Status:</strong> <span style="color: ' . $statusColor . '; font-weight: bold;">' . $record->status_label . '</span></div>';
                        $content .= '<div><strong>Progress:</strong> ' . $record->completion_percentage . '%</div>';
                        $content .= '<div><strong>Dimulai:</strong> ' . $record->created_at->format('d M Y, H:i') . '</div>';
                        if ($record->submitted_at) {
                            $content .= '<div><strong>Diserahkan:</strong> ' . $record->submitted_at->format('d M Y, H:i') . '</div>';
                            if ($record->response_duration) {
                                $duration = $record->response_duration;
                                if ($duration > 60) {
                                    $hours = intval($duration / 60);
                                    $minutes = $duration % 60;
                                    $durationText = "{$hours} jam {$minutes} menit";
                                } else {
                                    $durationText = "{$duration} menit";
                                }
                                $content .= '<div><strong>Durasi Pengisian:</strong> ' . $durationText . '</div>';
                            }
                        } else {
                            $content .= '<div><strong>Diserahkan:</strong> <span style="color: #6b7280;">Belum diserahkan</span></div>';
                        }
                        $content .= '<div><strong>Terakhir Diperbarui:</strong> ' . $record->updated_at->format('d M Y, H:i') . '</div>';
                        $content .= '</div>';
                        $content .= '</div>';
                        
                        // Overdue Warning
                        if ($record->is_overdue) {
                            $content .= '<div style="border: 1px solid #f59e0b; border-radius: 8px; padding: 16px; background: #fef3c7; margin-top: 16px;">';
                            $content .= '<h4 style="font-weight: bold; color: #92400e; margin-bottom: 8px;">⚠️ Peringatan Keterlambatan</h4>';
                            $content .= '<p style="color: #92400e;">Sesi survey telah berakhir tetapi respons belum diselesaikan. Segera hubungi alumni untuk menyelesaikan pengisian.</p>';
                            $content .= '</div>';
                        }
                        
                        // Metadata (if exists)
                        if (!empty($record->metadata)) {
                            $content .= '<div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; background: white; margin-top: 16px;">';
                            $content .= '<h4 style="font-weight: bold; color: #374151; margin-bottom: 12px;">🔍 Informasi Tambahan</h4>';
                            $content .= '<pre style="background: #f3f4f6; padding: 12px; border-radius: 4px; font-size: 12px;">';
                            $content .= json_encode($record->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                            $content .= '</pre>';
                            $content .= '</div>';
                        }
                        
                        $content .= '</div>';
                        
                        return new \Illuminate\Support\HtmlString($content);
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->searchPlaceholder('Cari nama alumni, NIM, sesi...')
            ->emptyStateHeading('Belum Ada Respons Survey')
            ->emptyStateDescription('Respons akan muncul setelah alumni mulai mengisi survey.')
            ->emptyStateIcon('heroicon-o-clipboard-document-check');
    }
}
