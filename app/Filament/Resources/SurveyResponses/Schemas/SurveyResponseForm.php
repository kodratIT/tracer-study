<?php

namespace App\Filament\Resources\SurveyResponses\Schemas;

use Modules\Survey\Models\TracerStudySession;
use Modules\Alumni\Models\Alumni;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\KeyValue;

class SurveyResponseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1: ALUMNI & SESSION INFO (READ ONLY)
                Section::make('👤 Informasi Alumni & Sesi')
                    ->description('Informasi dasar respons survey')
                    ->icon('heroicon-m-user')
                    ->columns(2)
                    ->schema([
                        Select::make('alumni_id')
                            ->label('Alumni')
                            ->relationship('alumni', 'name')
                            ->searchable()
                            ->preload()
                            ->disabled()
                            ->columnSpan(1),
                            
                        Select::make('session_id')
                            ->label('Sesi Tracer Study')
                            ->relationship(
                                name: 'session',
                                titleAttribute: 'year',
                                modifyQueryUsing: fn ($query) => $query->orderBy('year', 'desc')
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->display_name)
                            ->searchable()
                            ->preload()
                            ->disabled()
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),

                // SECTION 2: RESPONSE STATUS & TIMING
                Section::make('📊 Status & Waktu Respons')
                    ->description('Informasi status dan waktu pengisian')
                    ->icon('heroicon-m-clock')
                    ->columns(2)
                    ->schema([
                        Select::make('completion_status')
                            ->label('Status Pengisian')
                            ->options([
                                'draft' => 'Draft',
                                'partial' => 'Sebagian',
                                'completed' => 'Selesai',
                            ])
                            ->disabled()
                            ->columnSpan(1),
                            
                        DateTimePicker::make('submitted_at')
                            ->label('Tanggal Pengiriman')
                            ->disabled()
                            ->columnSpan(1),
                            
                        Placeholder::make('created_at_display')
                            ->label('Dimulai')
                            ->content(fn ($record) => $record?->created_at?->format('d M Y, H:i') ?? 'N/A')
                            ->columnSpan(1),
                            
                        Placeholder::make('updated_at_display')
                            ->label('Terakhir Diperbarui')
                            ->content(fn ($record) => $record?->updated_at?->format('d M Y, H:i') ?? 'N/A')
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),

                // SECTION 3: PROGRESS & STATISTICS (READ ONLY)
                Section::make('📈 Progress & Statistik')
                    ->description('Informasi kemajuan dan statistik respons')
                    ->icon('heroicon-m-chart-bar')
                    ->visible(fn ($record) => $record !== null)
                    ->schema([
                        Placeholder::make('completion_percentage_display')
                            ->label('Persentase Selesai')
                            ->content(fn ($record) => ($record?->completion_percentage ?? 0) . '%')
                            ->columnSpan(1),
                            
                        Placeholder::make('status_label_display')
                            ->label('Status')
                            ->content(fn ($record) => $record?->status_label ?? 'N/A')
                            ->columnSpan(1),
                            
                        Placeholder::make('time_since_display')
                            ->label('Waktu Relatif')
                            ->content(fn ($record) => $record?->time_since ?? 'N/A')
                            ->columnSpan(1),
                            
                        Placeholder::make('duration_display')
                            ->label('Durasi Pengisian')
                            ->content(function ($record) {
                                if (!$record?->response_duration) return 'Belum selesai';
                                
                                $duration = $record->response_duration;
                                if ($duration > 60) {
                                    $hours = intval($duration / 60);
                                    $minutes = $duration % 60;
                                    return "{$hours} jam {$minutes} menit";
                                }
                                return "{$duration} menit";
                            })
                            ->columnSpan(1),
                            
                        Placeholder::make('overdue_status_display')
                            ->label('Status Keterlambatan')
                            ->content(function ($record) {
                                if (!$record) return 'N/A';
                                
                                if ($record->is_overdue) {
                                    return '⚠️ Terlambat (sesi berakhir)';
                                } elseif ($record->completion_status === 'completed') {
                                    return '✅ Selesai tepat waktu';
                                } else {
                                    return '🔄 Dalam periode';
                                }
                            })
                            ->columnSpan(1),
                            
                        Placeholder::make('response_id_display')
                            ->label('ID Respons')
                            ->content(fn ($record) => $record?->response_id ?? 'N/A')
                            ->columnSpan(1),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                // SECTION 4: METADATA (IF EXISTS)
                Section::make('🔍 Informasi Tambahan')
                    ->description('Data metadata dan informasi tambahan')
                    ->icon('heroicon-m-information-circle')
                    ->visible(fn ($record) => $record !== null && !empty($record->metadata))
                    ->schema([
                        KeyValue::make('metadata')
                            ->label('Metadata')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
