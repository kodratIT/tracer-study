<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;

class AlumniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1: INFORMASI PRIBADI (Personal Information)
                Section::make('Informasi Pribadi')
                    ->description('Data diri dan kontak alumni')
                    ->icon('heroicon-m-user-circle')
                    ->columns(2)
                    ->schema([
                        TextInput::make('student_id')
                            ->label('NIM / Student ID')
                            ->placeholder('Contoh: 1234567890')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->prefixIcon('heroicon-m-identification')
                            ->columnSpan(1),
                            
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->placeholder('Masukkan nama lengkap')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-user')
                            ->columnSpan(1),
                            
                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('email@example.com')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-envelope')
                            ->columnSpan(1),
                            
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->placeholder('+62 812-3456-7890')
                            ->tel()
                            ->maxLength(20)
                            ->prefixIcon('heroicon-m-phone')
                            ->columnSpan(1),
                            
                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ])
                            ->placeholder('Pilih jenis kelamin')
                            ->prefixIcon('heroicon-m-user-group')
                            ->columnSpan(1),
                            
                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->placeholder('Pilih tanggal')
                            ->prefixIcon('heroicon-m-cake')
                            ->maxDate(now()->subYears(17))
                            ->columnSpan(1),
                    ])
                     ->columnSpanFull(),
                     
                // SECTION 2: INFORMASI AKADEMIK (Academic Information)
                Section::make('Informasi Akademik')
                    ->description('Data akademik dan program studi')
                    ->icon('heroicon-m-academic-cap')
                    ->columns(3)
                    ->schema([
                        Select::make('program_id')
                            ->label('Program Studi')
                            ->relationship('program', 'program_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Pilih program studi')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->program_name . ' (' . ($record->department->department_name ?? '-') . ')')
                            ->prefixIcon('heroicon-m-book-open')
                            ->columnSpan(1),
                            
                        TextInput::make('graduation_year')
                            ->label('Tahun Lulus')
                            ->placeholder(date('Y'))
                            ->numeric()
                            ->required()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 5)
                            ->prefixIcon('heroicon-m-calendar')
                            ->columnSpan(1),
                            
                        TextInput::make('gpa')
                            ->label('IPK / GPA')
                            ->placeholder('3.75')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(4)
                            ->helperText('Skala 4.00')
                            ->prefixIcon('heroicon-m-star')
                            ->columnSpan(1),
                    ])
                     ->columnSpanFull(),

                // SECTION 3: DATA PEKERJAAN (Employment Information - Optional)
                Section::make('Data Pekerjaan')
                    ->description('Informasi pekerjaan saat ini (opsional, bisa ditambah kemudian)')
                    ->icon('heroicon-m-briefcase')
                    ->collapsed()
                    ->collapsible()
                    ->schema([
                        Repeater::make('employmentHistories')
                            ->relationship()
                            ->label('Riwayat Pekerjaan')
                            ->schema([
                                Select::make('employment_status')
                                    ->label('Status Kegiatan')
                                    ->options([
                                        'employed' => 'Bekerja',
                                        'unemployed' => 'Tidak Bekerja',
                                        'studying' => 'Melanjutkan Studi',
                                        'entrepreneur' => 'Wiraswasta',
                                    ])
                                    ->required()
                                    ->default('employed')
                                    ->reactive()
                                    ->columnSpan(2),
                                    
                                Select::make('is_active')
                                    ->label('Status Aktif')
                                    ->boolean()
                                    ->options([
                                        1 => 'Aktif (Saat Ini)',
                                        0 => 'Tidak Aktif',
                                    ])
                                    ->default(1)
                                    ->helperText('Tandai jika ini adalah pekerjaan/kegiatan saat ini')
                                    ->columnSpan(2),
                                    
                                // For Employed/Entrepreneur
                                TextInput::make('job_title')
                                    ->label('Jabatan/Posisi')
                                    ->placeholder('Software Engineer')
                                    ->maxLength(255)
                                    ->visible(fn ($get) => in_array($get('employment_status'), ['employed', 'entrepreneur']))
                                    ->required(fn ($get) => in_array($get('employment_status'), ['employed', 'entrepreneur']))
                                    ->columnSpan(2),
                                    
                                Select::make('employer_id')
                                    ->label('Perusahaan')
                                    ->relationship('employer', 'employer_name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('employer_name')
                                            ->label('Nama Perusahaan')
                                            ->required()
                                            ->maxLength(255),
                                            
                                        TextInput::make('industry_type')
                                            ->label('Jenis Industri')
                                            ->placeholder('Teknologi, Pendidikan, dll')
                                            ->required()
                                            ->maxLength(100),
                                            
                                        TextInput::make('website')
                                            ->label('Website')
                                            ->url()
                                            ->maxLength(255),
                                    ])
                                    ->visible(fn ($get) => in_array($get('employment_status'), ['employed', 'entrepreneur']))
                                    ->placeholder('Pilih atau buat perusahaan baru')
                                    ->columnSpan(2),
                                    
                                Select::make('job_level')
                                    ->label('Level Jabatan')
                                    ->options([
                                        'entry' => 'Entry Level',
                                        'junior' => 'Junior',
                                        'mid' => 'Mid Level',
                                        'senior' => 'Senior',
                                        'lead' => 'Lead/Team Leader',
                                        'supervisor' => 'Supervisor',
                                        'manager' => 'Manager',
                                        'director' => 'Director',
                                        'vp' => 'Vice President',
                                        'ceo' => 'CEO/Founder',
                                    ])
                                    ->visible(fn ($get) => $get('employment_status') === 'employed')
                                    ->required(fn ($get) => $get('employment_status') === 'employed')
                                    ->columnSpan(2),
                                    
                                Select::make('contract_type')
                                    ->label('Jenis Kontrak')
                                    ->options([
                                        'full_time' => 'Full Time',
                                        'part_time' => 'Part Time',
                                        'contract' => 'Kontrak',
                                        'freelance' => 'Freelance',
                                        'internship' => 'Magang',
                                    ])
                                    ->visible(fn ($get) => $get('employment_status') === 'employed')
                                    ->required(fn ($get) => $get('employment_status') === 'employed')
                                    ->columnSpan(2),
                                    
                                Textarea::make('job_description')
                                    ->label('Deskripsi Pekerjaan')
                                    ->placeholder('Tugas dan tanggung jawab...')
                                    ->rows(3)
                                    ->visible(fn ($get) => in_array($get('employment_status'), ['employed', 'entrepreneur']))
                                    ->columnSpanFull(),
                                    
                                // For Studying
                                TextInput::make('institution_name')
                                    ->label('Nama Institusi')
                                    ->placeholder('Universitas ABC')
                                    ->maxLength(255)
                                    ->visible(fn ($get) => $get('employment_status') === 'studying')
                                    ->required(fn ($get) => $get('employment_status') === 'studying')
                                    ->columnSpan(2),
                                    
                                TextInput::make('study_level')
                                    ->label('Jenjang Pendidikan')
                                    ->placeholder('S2, S3, dll')
                                    ->maxLength(100)
                                    ->visible(fn ($get) => $get('employment_status') === 'studying')
                                    ->required(fn ($get) => $get('employment_status') === 'studying')
                                    ->columnSpan(1),
                                    
                                TextInput::make('major')
                                    ->label('Program Studi')
                                    ->placeholder('Teknik Informatika')
                                    ->maxLength(255)
                                    ->visible(fn ($get) => $get('employment_status') === 'studying')
                                    ->required(fn ($get) => $get('employment_status') === 'studying')
                                    ->columnSpan(1),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): ?string => 
                                match($state['employment_status'] ?? 'employed') {
                                    'employed' => ($state['job_title'] ?? 'Pekerjaan') . 
                                                  (isset($state['is_active']) && $state['is_active'] ? ' (Aktif)' : ''),
                                    'studying' => 'Studi: ' . ($state['institution_name'] ?? 'Institusi'),
                                    'entrepreneur' => 'Wiraswasta: ' . ($state['job_title'] ?? 'Usaha'),
                                    'unemployed' => 'Tidak Bekerja',
                                    default => 'Data Pekerjaan'
                                }
                            )
                            ->addActionLabel('+ Tambah Data Pekerjaan/Kegiatan')
                            ->collapsible()
                            ->columnSpanFull(),
                    ])
                     ->columnSpanFull(),
            ]);
    }
}
