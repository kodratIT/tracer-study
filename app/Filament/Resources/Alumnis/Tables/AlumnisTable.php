<?php

namespace App\Filament\Resources\Alumnis\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
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
                Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->url(fn ($record) => route('filament.admin.resources.alumnis.view', $record)),
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
