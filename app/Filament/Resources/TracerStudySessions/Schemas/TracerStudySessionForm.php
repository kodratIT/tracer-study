<?php

namespace App\Filament\Resources\TracerStudySessions\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;

class TracerStudySessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1: INFORMASI DASAR SESI (Basic Session Information)
                Section::make('📋 Informasi Dasar Sesi')
                    ->description('Data dasar untuk sesi tracer study')
                    ->icon('heroicon-m-clipboard-document-list')
                    ->columns(2)
                    ->schema([
                        TextInput::make('year')
                            ->label('Tahun')
                            ->placeholder('Contoh: 2024')
                            ->required()
                            ->numeric()
                            ->minValue(2020)
                            ->maxValue(date('Y') + 5)
                            ->default(date('Y'))
                            ->helperText('Tahun pelaksanaan tracer study')
                            ->columnSpan(1),
                            
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Aktifkan sesi untuk mulai mengumpulkan respons')
                            ->default(true)
                            ->columnSpan(1),
                            
                        Textarea::make('description')
                            ->label('Deskripsi Sesi')
                            ->placeholder('Contoh: Tracer Study untuk mengukur kepuasan alumni dan relevansi kurikulum...')
                            ->rows(3)
                            ->maxLength(1000)
                            ->helperText('Deskripsi tujuan dan fokus sesi tracer study')
                            ->columnSpanFull(),
                    ])
                     ->columnSpanFull(),

                // SECTION 2: PERIODE PELAKSANAAN (Execution Period)
                Section::make('📅 Periode Pelaksanaan')
                    ->description('Tentukan rentang waktu pelaksanaan survei')
                    ->icon('heroicon-m-calendar-days')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required()
                            ->placeholder('Pilih tanggal mulai survei')
                            ->helperText('Tanggal dimulainya periode pengumpulan data')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Auto-set end_date to 30 days after start_date if not set
                                if ($state && !request()->input('end_date')) {
                                    $endDate = \Carbon\Carbon::parse($state)->addDays(30);
                                    $set('end_date', $endDate->toDateString());
                                }
                            })
                            ->columnSpan(1),
                            
                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->required()
                            ->placeholder('Pilih tanggal selesai survei')
                            ->helperText('Tanggal berakhirnya periode pengumpulan data')
                            ->afterOrEqual('start_date')
                            ->columnSpan(1),
                    ])
                     ->columnSpanFull(),

                // SECTION 3: STATISTIK SESI (Session Statistics) - Only shown when editing
                Section::make('📊 Statistik Sesi')
                    ->description('Informasi respons dan partisipasi alumni')
                    ->icon('heroicon-m-chart-bar-square')
                    ->visible(fn ($record) => $record !== null)
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                Placeholder::make('total_responses')
                                    ->label('Total Respons')
                                    ->content(fn ($record) => $record?->total_responses_count ?? 0),
                                    
                                Placeholder::make('completed_responses')
                                    ->label('Respons Selesai')
                                    ->content(fn ($record) => $record?->completed_responses_count ?? 0),
                                    
                                Placeholder::make('partial_responses')
                                    ->label('Respons Sebagian')
                                    ->content(fn ($record) => $record?->partial_responses_count ?? 0),
                                    
                                Placeholder::make('response_rate')
                                    ->label('Tingkat Respons')
                                    ->content(fn ($record) => ($record?->response_rate ?? 0) . '%'),
                            ]),
                            
                        Grid::make(3)
                            ->schema([
                                Placeholder::make('duration')
                                    ->label('Durasi')
                                    ->content(fn ($record) => ($record?->duration ?? 0) . ' hari'),
                                    
                                Placeholder::make('status')
                                    ->label('Status Sesi')
                                    ->content(function ($record) {
                                        if (!$record) return 'Baru';
                                        
                                        return match($record->status) {
                                            'upcoming' => '⏳ Akan Datang',
                                            'ongoing' => '▶️ Sedang Berjalan',
                                            'expired' => '✅ Selesai',
                                            default => '❓ Tidak Diketahui',
                                        };
                                    }),
                                    
                                Placeholder::make('created_info')
                                    ->label('Dibuat')
                                    ->content(fn ($record) => $record?->created_at?->format('d M Y, H:i') ?? 'Baru'),
                            ]),
                    ])
                     ->columnSpanFull(),
            ]);
    }
}
