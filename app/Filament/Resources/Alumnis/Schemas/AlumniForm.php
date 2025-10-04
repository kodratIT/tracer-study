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
                            ->label('Tambah Pekerjaan')
                            ->schema([
                                TextInput::make('job_title')
                                    ->label('Jabatan')
                                    ->placeholder('Software Engineer')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                    
                                TextInput::make('company_name')
                                    ->label('Nama Perusahaan')
                                    ->placeholder('PT. Contoh Indonesia')
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                    
                                Select::make('employment_status')
                                    ->label('Status')
                                    ->options([
                                        'employed' => 'Bekerja',
                                        'unemployed' => 'Tidak Bekerja',
                                        'studying' => 'Melanjutkan Studi',
                                        'entrepreneur' => 'Wiraswasta',
                                    ])
                                    ->required()
                                    ->default('employed')
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
                                    ->placeholder('Pilih jenis kontrak')
                                    ->columnSpan(2),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): ?string => 
                                (!empty($state['job_title']) ? $state['job_title'] : 'Pekerjaan Baru') .
                                (!empty($state['company_name']) ? ' - ' . $state['company_name'] : '')
                            )
                            ->addActionLabel('+ Tambah Pekerjaan')
                            ->collapsible()
                            ->columnSpanFull(),
                    ])
                     ->columnSpanFull(),
            ]);
    }
}
