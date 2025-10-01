<?php

namespace App\Filament\Resources\Reports\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Schema;
use Modules\Reports\Models\Report;
use Modules\Survey\Models\TracerStudySession;
use Modules\Education\Models\Program;
use Modules\Alumni\Models\Alumni;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Laporan')
                    ->description('Konfigurasi dasar untuk laporan BAN-PT')
                    ->components([
                        Grid::make(2)
                            ->components([
                                TextInput::make('title')
                                    ->label('Judul Laporan')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('contoh: Laporan Tracer Study 2024'),

                                Select::make('report_type')
                                    ->label('Jenis Laporan')
                                    ->required()
                                    ->options(Report::REPORT_TYPES)
                                    ->reactive()
                                    ->placeholder('Pilih jenis laporan'),
                            ]),

                        Grid::make(2)
                            ->components([
                                Select::make('session_id')
                                    ->label('Sesi Tracer Study')
                                    ->options(TracerStudySession::all()->pluck('display_name', 'session_id'))
                                    ->searchable()
                                    ->placeholder('Pilih sesi tracer study'),

                                Select::make('file_format')
                                    ->label('Format File')
                                    ->options([
                                        Report::FORMAT_PDF => 'PDF',
                                        Report::FORMAT_EXCEL => 'Excel',
                                        Report::FORMAT_CSV => 'CSV',
                                    ])
                                    ->default(Report::FORMAT_PDF)
                                    ->required(),
                            ]),
                    ]),

                Section::make('Parameter Laporan')
                    ->description('Konfigurasi filter dan parameter tambahan')
                    ->components([
                        Grid::make(2)
                            ->components([
                                Select::make('parameters.graduation_years')
                                    ->label('Tahun Lulus')
                                    ->multiple()
                                    ->options(function () {
                                        $years = [];
                                        $currentYear = date('Y');
                                        for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                                            $years[$year] = $year;
                                        }
                                        return $years;
                                    })
                                    ->placeholder('Semua tahun lulus'),

                                Select::make('parameters.programs')
                                    ->label('Program Studi')
                                    ->multiple()
                                    ->options(Program::all()->pluck('program_name', 'program_id'))
                                    ->searchable()
                                    ->placeholder('Semua program studi'),
                            ]),

                        Grid::make(2)
                            ->components([
                                Select::make('parameters.completion_status')
                                    ->label('Status Respons')
                                    ->multiple()
                                    ->options([
                                        'completed' => 'Selesai',
                                        'partial' => 'Sebagian',
                                        'draft' => 'Draft',
                                    ])
                                    ->default(['completed'])
                                    ->placeholder('Semua status'),

                                Select::make('parameters.employment_status')
                                    ->label('Status Ketenagakerjaan')
                                    ->multiple()
                                    ->options([
                                        'employed' => 'Bekerja',
                                        'unemployed' => 'Tidak Bekerja',
                                        'entrepreneur' => 'Wirausaha',
                                        'continuing_study' => 'Melanjutkan Studi',
                                    ])
                                    ->placeholder('Semua status ketenagakerjaan'),
                            ]),
                    ])
                    ->visible(fn ($get) => in_array($get('report_type'), [
                        'employment_statistics',
                        'waiting_period', 
                        'job_relevance',
                        'ban_pt_standard'
                    ])),

                Section::make('Pengaturan Tambahan')
                    ->description('Konfigurasi tambahan untuk laporan')
                    ->components([
                        Grid::make(3)
                            ->components([
                                Checkbox::make('parameters.include_charts')
                                    ->label('Sertakan Grafik')
                                    ->default(true)
                                    ->helperText('Tambahkan grafik dan visualisasi data'),

                                Checkbox::make('parameters.include_raw_data')
                                    ->label('Sertakan Data Mentah')
                                    ->default(false)
                                    ->helperText('Tambahkan tabel data mentah di lampiran'),

                                Checkbox::make('parameters.auto_expire')
                                    ->label('Kedaluwarsa Otomatis')
                                    ->default(true)
                                    ->helperText('Hapus otomatis setelah 30 hari'),
                            ]),

                        KeyValue::make('parameters.custom_filters')
                            ->label('Filter Kustom')
                            ->keyLabel('Parameter')
                            ->valueLabel('Nilai')
                            ->helperText('Tambahkan filter kustom sesuai kebutuhan'),
                    ])
                    ->collapsed(),
            ]);
    }
}
