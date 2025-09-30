<?php

namespace App\Filament\Resources\Faculties\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Modules\Education\Models\Campus;

class FacultyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('🏫 Informasi Fakultas')
                    ->description('Data informasi fakultas dan campus induk')
                    ->icon('heroicon-m-academic-cap')
                    ->schema([
                        TextInput::make('faculty_name')
                            ->label('Nama Fakultas')
                            ->placeholder('Contoh: Fakultas Teknik')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                            
                        Select::make('campus_id')
                            ->label('Campus Induk')
                            ->relationship('campus', 'campus_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Pilih campus induk')
                            ->helperText('Fakultas ini berada di campus mana?')
                            ->getOptionLabelFromRecordUsing(fn (Campus $record): string => "{$record->campus_name} ({$record->city}, {$record->province})"),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
