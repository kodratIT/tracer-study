<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Modules\Education\Models\Faculty;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('🏛️ Informasi Jurusan')
                    ->description('Data informasi jurusan dan fakultas induk')
                    ->icon('heroicon-m-squares-2x2')
                    ->schema([
                        TextInput::make('department_name')
                            ->label('Nama Jurusan')
                            ->placeholder('Contoh: Teknik Informatika')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                            
                        Select::make('faculty_id')
                            ->label('Fakultas Induk')
                            ->relationship('faculty', 'faculty_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Pilih fakultas induk')
                            ->helperText('Jurusan ini berada di fakultas mana?')
                            ->getOptionLabelFromRecordUsing(function (Faculty $record): string {
                                return "{$record->faculty_name} - {$record->campus->campus_name}";
                            }),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
