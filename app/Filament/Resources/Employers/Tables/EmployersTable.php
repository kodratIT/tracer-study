<?php

namespace App\Filament\Resources\Employers\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class EmployersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employer_name')
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->website ? "🌐 {$record->website}" : null),
                    
                BadgeColumn::make('industry_type')
                    ->label('Industri')
                    ->searchable()
                    ->sortable()
                    ->colors([
                        'success' => 'Technology',
                        'warning' => 'Finance',
                        'danger' => 'Healthcare',
                        'info' => 'Education',
                        'secondary' => fn ($state) => !in_array($state, ['Technology', 'Finance', 'Healthcare', 'Education']),
                    ])
                    ->icons([
                        'Technology' => 'heroicon-m-computer-desktop',
                        'Finance' => 'heroicon-m-currency-dollar',
                        'Healthcare' => 'heroicon-m-heart',
                        'Education' => 'heroicon-m-academic-cap',
                        'Manufacturing' => 'heroicon-m-cog-6-tooth',
                        'Retail' => 'heroicon-m-shopping-cart',
                        'Construction' => 'heroicon-m-wrench-screwdriver',
                        'Transportation' => 'heroicon-m-truck',
                        'Energy' => 'heroicon-m-bolt',
                        'Agriculture' => 'heroicon-m-sun',
                        'Media' => 'heroicon-m-tv',
                        'Consulting' => 'heroicon-m-briefcase',
                        'Government' => 'heroicon-m-building-library',
                        'Non-Profit' => 'heroicon-m-heart',
                        'Startup' => 'heroicon-m-rocket-launch',
                        'Other' => 'heroicon-m-ellipsis-horizontal',
                    ])
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'Technology' => '💻 Teknologi',
                            'Finance' => '💰 Keuangan',
                            'Healthcare' => '🏥 Kesehatan',
                            'Education' => '🎓 Pendidikan',
                            'Manufacturing' => '🏭 Manufaktur',
                            'Retail' => '🛒 Retail',
                            'Construction' => '🏗️ Konstruksi',
                            'Transportation' => '🚛 Transportasi',
                            'Energy' => '⚡ Energi',
                            'Agriculture' => '🌾 Pertanian',
                            'Media' => '📺 Media',
                            'Consulting' => '💼 Konsultan',
                            'Government' => '🏛️ Pemerintahan',
                            'Non-Profit' => '🤝 Non-Profit',
                            'Startup' => '🚀 Startup',
                            default => '🔄 ' . $state,
                        };
                    }),
                    
                TextColumn::make('address.city')
                    ->label('Kota')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—')
                    ->description(fn ($record) => $record->address?->province),
                    
                TextColumn::make('employment_histories_count')
                    ->label('Jumlah Alumni')
                    ->counts('employmentHistories')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('info'),
                    
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('industry_type')
                    ->label('Filter Industri')
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
                    ->placeholder('Semua Industri'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Dipilih')
                        ->icon('heroicon-m-trash'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->searchPlaceholder('Cari nama perusahaan atau website...')
            ->emptyStateHeading('Belum Ada Data Perusahaan')
            ->emptyStateDescription('Mulai menambahkan data perusahaan atau organisasi tempat alumni bekerja.')
            ->emptyStateIcon('heroicon-o-building-office-2');
    }
}
