<?php

namespace App\Filament\Resources\Employments\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;

class EmploymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1: INFORMASI ALUMNI (Alumni Information)
                Section::make('👤 Informasi Alumni')
                    ->description('Alumni yang memiliki riwayat pekerjaan ini')
                    ->icon('heroicon-m-user-circle')
                    ->columns(1)
                    ->schema([
                        Select::make('alumni_id')
                            ->label('Alumni')
                            ->relationship('alumni', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Pilih alumni')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->student_id})")
                            ->columnSpanFull(),
                    ])
                     ->columnSpanFull(),

                // SECTION 2: INFORMASI PEKERJAAN (Employment Information)
                Section::make('💼 Detail Pekerjaan')
                    ->description('Informasi detail mengenai posisi dan perusahaan')
                    ->icon('heroicon-m-briefcase')
                    ->columns(2)
                    ->schema([
                        TextInput::make('job_title')
                            ->label('Jabatan/Posisi')
                            ->placeholder('Contoh: Software Engineer, Marketing Manager')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                            
                        Select::make('employer_id')
                            ->label('Perusahaan')
                            ->relationship('employer', 'employer_name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih perusahaan atau kosongkan jika tidak terdaftar')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->employer_name} ({$record->industry_type})")
                            ->createOptionForm([
                                TextInput::make('employer_name')
                                    ->label('Nama Perusahaan')
                                    ->required()
                                    ->maxLength(255),
                                    
                                Select::make('industry_type')
                                    ->label('Jenis Industri')
                                    ->options([
                                        'Technology' => '💻 Teknologi & IT',
                                        'Finance' => '💰 Keuangan & Perbankan',
                                        'Healthcare' => '🏥 Kesehatan & Medis',
                                        'Education' => '🎓 Pendidikan',
                                        'Manufacturing' => '🏭 Manufaktur',
                                        'Retail' => '🛒 Retail & E-commerce',
                                        'Construction' => '🏗️ Konstruksi',
                                        'Transportation' => '🚛 Transportasi & Logistik',
                                        'Energy' => '⚡ Energi & Utility',
                                        'Agriculture' => '🌾 Pertanian',
                                        'Media' => '📺 Media & Entertainment',
                                        'Consulting' => '💼 Konsultan',
                                        'Government' => '🏛️ Pemerintahan',
                                        'Non-Profit' => '🤝 Non-Profit',
                                        'Startup' => '🚀 Startup',
                                        'Other' => '🔄 Lainnya',
                                    ])
                                    ->required(),
                                    
                                TextInput::make('website')
                                    ->label('Website Perusahaan')
                                    ->url()
                                    ->maxLength(255),
                            ])
                            ->columnSpan(1),
                            
                        TextInput::make('company_name')
                            ->label('Nama Perusahaan (Manual)')
                            ->placeholder('Isi jika perusahaan tidak ada dalam daftar')
                            ->maxLength(255)
                            ->helperText('Alternatif jika perusahaan belum terdaftar')
                            ->columnSpan(1),
                    ])
                     ->columnSpanFull(),

                // SECTION 3: DETAIL POSISI (Position Details)
                Section::make('📊 Detail Posisi & Kontrak')
                    ->description('Level jabatan, jenis kontrak, dan informasi gaji')
                    ->icon('heroicon-m-chart-bar')
                    ->columns(2)
                    ->schema([
                        Select::make('job_level')
                            ->label('Level Jabatan')
                            ->options([
                                'entry' => '🎯 Entry Level',
                                'junior' => '🔰 Junior',
                                'mid' => '📈 Mid Level',
                                'senior' => '⭐ Senior',
                                'lead' => '👑 Lead/Team Leader',
                                'supervisor' => '📋 Supervisor',
                                'manager' => '🎖️ Manager',
                                'director' => '🏛️ Director',
                                'vp' => '🚀 Vice President',
                                'ceo' => '👔 CEO/Founder',
                            ])
                            ->required()
                            ->placeholder('Pilih level jabatan')
                            ->columnSpan(1),
                            
                        Select::make('contract_type')
                            ->label('Jenis Kontrak')
                            ->options([
                                'full_time' => '⏰ Full Time',
                                'part_time' => '🕐 Part Time',
                                'contract' => '📋 Kontrak',
                                'freelance' => '🆓 Freelance',
                                'internship' => '🎓 Magang/Intern',
                            ])
                            ->required()
                            ->placeholder('Pilih jenis kontrak')
                            ->columnSpan(1),
                            
                        TextInput::make('salary_range')
                            ->label('Rentang Gaji')
                            ->placeholder('Contoh: 5-10 juta, $3000-5000, Negotiable')
                            ->maxLength(100)
                            ->helperText('Opsional - informasi rentang gaji')
                            ->columnSpan(2),
                    ])
                     ->columnSpanFull(),

                // SECTION 4: PERIODE KERJA (Employment Period)
                Section::make('📅 Periode Pekerjaan')
                    ->description('Tanggal mulai dan selesai bekerja')
                    ->icon('heroicon-m-calendar-days')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required()
                            ->placeholder('Pilih tanggal mulai bekerja')
                            ->columnSpan(1),
                            
                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->placeholder('Kosongkan jika masih bekerja')
                            ->helperText('Biarkan kosong jika masih aktif bekerja')
                            ->columnSpan(1),
                    ])
                     ->columnSpanFull(),
            ]);
    }
}
