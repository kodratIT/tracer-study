<?php

namespace App\Filament\Resources\Employments\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class EmploymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('alumni.name')
                    ->label('Alumni')
                    ->searchable(['name', 'student_id'])
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->alumni?->student_id),
                    
                TextColumn::make('job_title')
                    ->label('Jabatan')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->employer?->employer_name ?? 'Tidak diketahui'),
                    
                BadgeColumn::make('job_level')
                    ->label('Level')
                    ->searchable()
                    ->sortable()
                    ->colors([
                        'secondary' => ['entry', 'junior'],
                        'warning' => ['mid', 'senior'],
                        'success' => ['lead', 'supervisor'],
                        'info' => ['manager', 'director'],
                        'danger' => ['vp', 'ceo'],
                    ])
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'entry' => '🎯 Entry',
                            'junior' => '🔰 Junior',
                            'mid' => '📈 Mid',
                            'senior' => '⭐ Senior',
                            'lead' => '👑 Lead',
                            'supervisor' => '📋 Supervisor',
                            'manager' => '🎖️ Manager',
                            'director' => '🏛️ Director',
                            'vp' => '🚀 VP',
                            'ceo' => '👔 CEO',
                            default => ucfirst($state),
                        };
                    }),
                    
                BadgeColumn::make('contract_type')
                    ->label('Kontrak')
                    ->searchable()
                    ->sortable()
                    ->colors([
                        'success' => 'full_time',
                        'warning' => 'part_time',
                        'info' => 'contract',
                        'secondary' => 'freelance',
                        'primary' => 'internship',
                    ])
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'full_time' => '⏰ Full Time',
                            'part_time' => '🕐 Part Time',
                            'contract' => '📋 Kontrak',
                            'freelance' => '🆓 Freelance',
                            'internship' => '🎓 Magang',
                            default => ucfirst($state),
                        };
                    }),
                    
                TextColumn::make('employer.industry_type')
                    ->label('Industri')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—')
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
                            default => $state ? '🔄 ' . $state : '—',
                        };
                    }),
                    
                BadgeColumn::make('employment_status')
                    ->label('Status Kegiatan')
                    ->searchable()
                    ->sortable()
                    ->colors([
                        'success' => 'employed',
                        'warning' => 'entrepreneur',
                        'info' => 'studying',
                        'secondary' => 'unemployed',
                    ])
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'employed' => '💼 Bekerja',
                            'unemployed' => '⏸️ Tidak Bekerja',
                            'studying' => '📚 Melanjutkan Studi',
                            'entrepreneur' => '🚀 Wiraswasta',
                            default => ucfirst($state),
                        };
                    }),
                    
                IconColumn::make('is_active')
                    ->label('Status Aktif')
                    ->sortable()
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('secondary')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                    
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
                SelectFilter::make('job_level')
                    ->label('Filter Level')
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
                    ->placeholder('Semua Level'),
                    
                SelectFilter::make('contract_type')
                    ->label('Filter Kontrak')
                    ->options([
                        'full_time' => '⏰ Full Time',
                        'part_time' => '🕐 Part Time',
                        'contract' => '📋 Kontrak',
                        'freelance' => '🆓 Freelance',
                        'internship' => '🎓 Magang/Intern',
                    ])
                    ->placeholder('Semua Kontrak'),
                    
                SelectFilter::make('employer.industry_type')
                    ->label('Filter Industri')
                    ->relationship('employer', 'industry_type')
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
                    
                SelectFilter::make('employment_status')
                    ->label('Filter Status Kegiatan')
                    ->options([
                        'employed' => '💼 Bekerja',
                        'unemployed' => '⏸️ Tidak Bekerja',
                        'studying' => '📚 Melanjutkan Studi',
                        'entrepreneur' => '🚀 Wiraswasta',
                    ])
                    ->placeholder('Semua Status'),
                    
                SelectFilter::make('is_active')
                    ->label('Filter Status Aktif')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ])
                    ->placeholder('Semua'),
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
            ->defaultSort('is_active', 'desc')
            ->striped()
            ->searchPlaceholder('Cari alumni, jabatan, atau perusahaan...')
            ->emptyStateHeading('Belum Ada Data Riwayat Pekerjaan')
            ->emptyStateDescription('Mulai menambahkan riwayat pekerjaan alumni untuk melacak karir mereka.')
            ->emptyStateIcon('heroicon-o-briefcase');
    }
}
