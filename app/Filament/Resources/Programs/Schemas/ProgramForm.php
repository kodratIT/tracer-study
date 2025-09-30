<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Modules\Education\Models\Department;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('🏛️ Informasi Jurusan & Program Studi')
                    ->description('Data informasi program studi lengkap dengan jurusan dan fakultas')
                    ->icon('heroicon-m-book-open')
                    ->schema([
                        Select::make('department_id')
                            ->label('Jurusan')
                            ->relationship('department', 'department_name')
                            ->createOptionForm([
                                Select::make('faculty_id')
                                    ->label('Fakultas')
                                    ->relationship('faculty', 'faculty_name')
                                    ->required()
                                    ->searchable(),
                                TextInput::make('department_name')
                                    ->label('Nama Jurusan')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Pilih atau buat jurusan baru')
                            ->helperText('Jika jurusan belum ada, klik + untuk menambah jurusan baru')
                            ->getOptionLabelFromRecordUsing(function (Department $record): string {
                                return "{$record->department_name} - {$record->faculty->faculty_name} ({$record->faculty->campus->campus_name})";
                            }),
                            
                        TextInput::make('program_name')
                            ->label('Nama Program Studi')
                            ->placeholder('Contoh: S1 Teknik Informatika')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                            
                        Grid::make(2)
                            ->schema([
                                Select::make('accreditation_status')
                                    ->label('Status Akreditasi')
                                    ->options([
                                        'A' => '🥇 A (Sangat Baik)',
                                        'B' => '🥈 B (Baik)',
                                        'C' => '🥉 C (Cukup)',
                                        'Unggul' => '⭐ Unggul',
                                        'Baik Sekali' => '✨ Baik Sekali',
                                        'Baik' => '👍 Baik',
                                    ])
                                    ->required()
                                    ->placeholder('Pilih status akreditasi'),
                                    
                                TextInput::make('start_year')
                                    ->label('Tahun Mulai')
                                    ->placeholder('2020')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1900)
                                    ->maxValue(date('Y') + 5),
                            ]),
                            
                        TextInput::make('end_year')
                            ->label('Tahun Berakhir (Opsional)')
                            ->placeholder('Kosongkan jika masih aktif')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 10)
                            ->helperText('Kosongkan jika program masih aktif'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
