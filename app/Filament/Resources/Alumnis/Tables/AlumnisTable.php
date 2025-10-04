<?php

namespace App\Filament\Resources\Alumnis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select as FormsSelect;
use Illuminate\Database\Eloquent\Builder;

class AlumnisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Primary Identity Columns
                TextColumn::make('student_id')
                    ->label('Student ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->color('gray')
                    ->weight(FontWeight::Medium),
                    
                TextColumn::make('name')
                    ->label('Nama Alumni')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn ($record) => $record->email)
                    ->wrap(),
                    
                // Program Studi
                TextColumn::make('program.program_name')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->description(fn ($record) => $record->program?->department?->department_name ?? '-')
                    ->icon('heroicon-m-academic-cap')
                    ->toggleable(),
                    
                // Academic Information
                TextColumn::make('graduation_year')
                    ->label('Lulus')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->alignCenter(),
                    
                TextColumn::make('gpa')
                    ->label('IPK')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->badge()
                    ->alignCenter()
                    ->color(fn ($state) => match (true) {
                        $state >= 3.5 => 'success',
                        $state >= 3.0 => 'warning',
                        $state >= 2.5 => 'danger',
                        default => 'gray',
                    }),
                    
                // Personal Information
                TextColumn::make('gender')
                    ->label('Gender')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'male' => 'blue',
                        'female' => 'pink',
                        default => 'gray',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone')
                    ->toggleable(),
                    
                // Employment Status
                TextColumn::make('employment_status')
                    ->label('Status Pekerjaan')
                    ->badge()
                    ->state(function ($record) {
                        $hasEmployment = \Modules\Employment\Models\EmploymentHistory::where('alumni_id', $record->alumni_id)->exists();
                        return $hasEmployment ? 'Terisi' : 'Belum Ada';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Terisi' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Terisi' => 'heroicon-m-check-circle',
                        default => 'heroicon-m-minus-circle',
                    })
                    ->alignCenter()
                    ->toggleable(),
                    
                // Survey Status
                TextColumn::make('survey_status')
                    ->label('Status Survey')
                    ->badge()
                    ->state(function ($record) {
                        $activeSurveySession = \Modules\Survey\Models\TracerStudySession::active()->first();
                        if (!$activeSurveySession) {
                            return 'Tidak Ada';
                        }
                        
                        $surveyResponse = \Modules\Survey\Models\SurveyResponse::where('alumni_id', $record->alumni_id)
                            ->where('session_id', $activeSurveySession->session_id)
                            ->first();
                            
                        if (!$surveyResponse) {
                            return 'Belum Mulai';
                        }
                        
                        return match ($surveyResponse->completion_status) {
                            'completed' => 'Selesai',
                            'partial' => 'Dalam Proses',
                            default => 'Draft',
                        };
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Selesai' => 'success',
                        'Dalam Proses' => 'warning',
                        'Draft' => 'info',
                        'Belum Mulai' => 'gray',
                        'Tidak Ada' => 'gray',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Selesai' => 'heroicon-m-check-badge',
                        'Dalam Proses' => 'heroicon-m-clock',
                        'Draft' => 'heroicon-m-pencil-square',
                        'Belum Mulai' => 'heroicon-m-minus-circle',
                        'Tidak Ada' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->alignCenter()
                    ->toggleable(),
                    
                // Address Information
                TextColumn::make('address.city')
                    ->label('Kota')
                    ->searchable()
                    ->icon('heroicon-m-map-pin')
                    ->toggleable(),
                    
                TextColumn::make('address.province')
                    ->label('Provinsi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                    
                // Timestamps
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-m-calendar'),
                    
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-m-clock'),
            ])
            ->filters([
                // Graduation Year Range Filter
                Filter::make('graduation_year')
                    ->label('Filter Tahun Lulus')
                    ->form([
                        FormsSelect::make('graduation_year_from')
                            ->label('Dari Tahun')
                            ->options(array_combine(
                                range(date('Y'), 1950), 
                                range(date('Y'), 1950)
                            ))
                            ->placeholder('Pilih tahun mulai')
                            ->searchable(),
                            
                        FormsSelect::make('graduation_year_to')
                            ->label('Sampai Tahun')
                            ->options(array_combine(
                                range(date('Y'), 1950), 
                                range(date('Y'), 1950)
                            ))
                            ->placeholder('Pilih tahun akhir')
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['graduation_year_from'],
                                fn (Builder $query, $year): Builder => $query->where('graduation_year', '>=', $year),
                            )
                            ->when(
                                $data['graduation_year_to'],
                                fn (Builder $query, $year): Builder => $query->where('graduation_year', '<=', $year),
                            );
                    }),
                    
                // Gender Filter
                SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',
                    ])
                    ->placeholder('Semua Gender'),
                    
                // Program Studi Filter
                SelectFilter::make('program_id')
                    ->label('Program Studi')
                    ->relationship('program', 'program_name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Semua Program'),
                    
                // Employment Status Filter
                SelectFilter::make('employment_status')
                    ->label('Status Pekerjaan')
                    ->options([
                        'has_employment' => 'Terisi',
                        'no_employment' => 'Belum Ada',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!isset($data['value'])) {
                            return $query;
                        }
                        
                        return $query->when(
                            $data['value'] === 'has_employment',
                            fn (Builder $query): Builder => $query->whereHas('employmentHistories'),
                        )->when(
                            $data['value'] === 'no_employment',
                            fn (Builder $query): Builder => $query->whereDoesntHave('employmentHistories'),
                        );
                    })
                    ->placeholder('Semua Status'),
                    
                // GPA Range Filter
                Filter::make('gpa')
                    ->label('Filter IPK')
                    ->form([
                        TextInput::make('gpa_from')
                            ->label('IPK Minimal')
                            ->placeholder('2.00')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(4),
                            
                        TextInput::make('gpa_to')
                            ->label('IPK Maksimal')
                            ->placeholder('4.00')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(4),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['gpa_from'],
                                fn (Builder $query, $gpa): Builder => $query->where('gpa', '>=', $gpa),
                            )
                            ->when(
                                $data['gpa_to'],
                                fn (Builder $query, $gpa): Builder => $query->where('gpa', '<=', $gpa),
                            );
                    }),
                    
                // City Filter
                SelectFilter::make('address.city')
                    ->label('Kota')
                    ->relationship('address', 'city')
                    ->searchable()
                    ->placeholder('Semua Kota'),
                    
                // Province Filter  
                SelectFilter::make('address.province')
                    ->label('Provinsi')
                    ->relationship('address', 'province')
                    ->searchable()
                    ->placeholder('Semua Provinsi'),
                    

            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-m-eye'),
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-m-pencil-square'),
                DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-m-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->icon('heroicon-m-trash'),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Data Alumni')
            ->emptyStateDescription('Mulai dengan menambahkan data alumni pertama menggunakan tombol "Tambah Alumni".')
            ->emptyStateIcon('heroicon-o-academic-cap')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultSort('created_at', 'desc');
    }
}
