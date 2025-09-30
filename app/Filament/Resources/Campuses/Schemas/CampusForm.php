<?php

namespace App\Filament\Resources\Campuses\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

class CampusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('🏛️ Informasi Campus')
                    ->description('Data informasi campus dan lokasi')
                    ->icon('heroicon-m-building-office-2')
                    ->schema([
                        TextInput::make('campus_name')
                            ->label('Nama Campus')
                            ->placeholder('Contoh: Universitas Indonesia - Depok')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                            
                        Grid::make(2)
                            ->schema([
                                TextInput::make('city')
                                    ->label('Kota/Kabupaten')
                                    ->placeholder('Contoh: Jakarta Selatan')
                                    ->required()
                                    ->maxLength(100),
                                    
                                TextInput::make('province')
                                    ->label('Provinsi')
                                    ->placeholder('Contoh: DKI Jakarta')
                                    ->required()
                                    ->maxLength(100),
                            ])
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
