<?php

namespace App\Filament\Resources\Reports\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Modules\Reports\Models\Report;
use Modules\Survey\Models\TracerStudySession;
use Modules\Education\Models\Program;
use Modules\Alumni\Models\Alumni;
use Illuminate\Support\Facades\Cache;
use App\Services\Reports\ReportGeneratorService;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        $currentYear = date('Y');
        
        return $schema
            ->components([
                Section::make('📊 Generate Laporan Tracer Study')
                    ->description('Pilih jenis laporan dan konfigurasi yang diinginkan')
                    ->schema([
                        Select::make('report_type')
                            ->label('Jenis Laporan')
                            ->required()
                            ->options([
                                'response_rate' => '📈 Laporan Response Rate - Monitor tingkat partisipasi alumni',
                                'employment_statistics' => '💼 Laporan Statistik Ketenagakerjaan - Status pekerjaan alumni',
                                'waiting_period' => '⏱️ Laporan Masa Tunggu Kerja - Waktu mendapat pekerjaan pertama',
                                'job_relevance' => '🎯 Laporan Relevansi Pekerjaan - Kesesuaian bidang kerja',
                                'salary_analysis' => '💰 Laporan Analisis Gaji - Pendapatan alumni',
                                'competency_analysis' => '🎓 Laporan Analisis Kompetensi - Gap analysis skills',
                                'geographic_distribution' => '🗺️ Laporan Distribusi Geografis - Sebaran lokasi kerja',
                                'ban_pt_standard' => '📋 Laporan Standar BAN-PT - Laporan lengkap akreditasi',
                            ])
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Auto-generate title
                                $session = TracerStudySession::find($get('session_id'));
                                $title = ReportGeneratorService::getDefaultTitle($state, $session);
                                $set('title', $title);
                            })
                            ->helperText('Pilih jenis laporan yang akan di-generate')
                            ->columnSpanFull(),

                        TextInput::make('title')
                            ->label('Judul Laporan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Auto-generated berdasarkan jenis laporan')
                            ->helperText('Judul dapat diubah sesuai kebutuhan')
                            ->columnSpanFull(),
                    ]),

                Section::make('🎯 Tracer Study Session')
                    ->description('Pilih sesi tracer study untuk laporan')
                    ->schema([
                        Select::make('session_id')
                            ->label('Tracer Study Session')
                            ->options(function () {
                                return TracerStudySession::orderBy('year', 'desc')
                                    ->get()
                                    ->mapWithKeys(function ($session) {
                                        $label = "Tracer Study {$session->year}";
                                        if ($session->is_active) {
                                            $label .= " (Aktif)";
                                        }
                                        return [$session->session_id => $label];
                                    });
                            })
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Update title when session changes
                                if ($get('report_type')) {
                                    $session = TracerStudySession::find($state);
                                    $title = ReportGeneratorService::getDefaultTitle($get('report_type'), $session);
                                    $set('title', $title);
                                }
                            })
                            ->helperText('Kosongkan untuk include semua sesi')
                            ->columnSpanFull(),
                    ]),

                Section::make('🔍 Filter (Opsional)')
                    ->description('Filter data berdasarkan kriteria tertentu')
                    ->collapsed()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('parameters.program_ids')
                                    ->label('Program Studi')
                                    ->multiple()
                                    ->options(function () {
                                        return Program::orderBy('program_name')
                                            ->pluck('program_name', 'program_id');
                                    })
                                    ->searchable()
                                    ->helperText('Kosongkan untuk semua program'),

                                Select::make('parameters.graduation_year_from')
                                    ->label('Tahun Lulus Dari')
                                    ->options(function () use ($currentYear) {
                                        $years = [];
                                        for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                                            $years[$year] = $year;
                                        }
                                        return $years;
                                    })
                                    ->helperText('Filter tahun lulus minimum'),
                            ]),

                        Select::make('parameters.graduation_year_to')
                            ->label('Tahun Lulus Sampai')
                            ->options(function () use ($currentYear) {
                                $years = [];
                                for ($year = $currentYear + 5; $year >= $currentYear - 10; $year--) {
                                    $years[$year] = $year;
                                }
                                return $years;
                            })
                            ->helperText('Filter tahun lulus maksimum')
                            ->columnSpanFull(),
                    ]),

                Section::make('📄 Output')
                    ->description('Konfigurasi format dan output laporan')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('file_format')
                                    ->label('Format File')
                                    ->options([
                                        Report::FORMAT_PDF => '📕 PDF',
                                        Report::FORMAT_EXCEL => '📗 Excel',
                                        Report::FORMAT_CSV => '📄 CSV',
                                    ])
                                    ->default(Report::FORMAT_PDF)
                                    ->required()
                                    ->helperText('Format file yang akan di-generate'),

                                Toggle::make('parameters.include_charts')
                                    ->label('Sertakan Grafik')
                                    ->default(true)
                                    ->helperText('Untuk PDF & Excel')
                                    ->inline(false),

                                Toggle::make('parameters.include_detailed_data')
                                    ->label('Sertakan Detail Data')
                                    ->default(true)
                                    ->helperText('Data lengkap per alumni')
                                    ->inline(false),
                            ]),
                    ]),

            ]);
    }
}
