<?php

namespace App\Filament\Resources\Employers\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class EmployerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1: INFORMASI PERUSAHAAN (Company Information)
                Section::make('🏢 Informasi Perusahaan')
                    ->description('Data dasar perusahaan dan organisasi')
                    ->icon('heroicon-m-building-office-2')
                    ->columns(2)
                    ->schema([
                        TextInput::make('employer_name')
                            ->label('Nama Perusahaan')
                            ->placeholder('Contoh: PT. Teknologi Nusantara, Google Indonesia')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                            
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
                            ->required()
                            ->placeholder('Pilih jenis industri')
                            ->columnSpan(1),
                            
                        TextInput::make('website')
                            ->label('Website Perusahaan')
                            ->placeholder('https://www.perusahaan.com')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Opsional - URL website resmi perusahaan')
                            ->columnSpan(1),
                    ])
                     ->columnSpanFull(),

                // SECTION 2: ALAMAT PERUSAHAAN (Company Address)
                Section::make('📍 Alamat Perusahaan')
                    ->description('Lokasi kantor pusat atau cabang utama')
                    ->icon('heroicon-m-map-pin')
                    ->collapsed()
                    ->schema([
                        Select::make('address_id')
                            ->label('Alamat Kantor')
                            ->relationship('address', 'street')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih alamat atau tambah alamat baru')
                            ->createOptionForm([
                                TextInput::make('street')
                                    ->label('Alamat Jalan')
                                    ->placeholder('Contoh: Jl. Sudirman No. 123, Gedung XYZ Lt. 15')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                    
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
                                    ]),
                                    
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('postal_code')
                                            ->label('Kode Pos')
                                            ->placeholder('12345')
                                            ->required()
                                            ->maxLength(10),
                                            
                                        TextInput::make('country')
                                            ->label('Negara')
                                            ->default('Indonesia')
                                            ->required()
                                            ->maxLength(100),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ])
                     ->columnSpanFull(),
            ]);
    }
}
