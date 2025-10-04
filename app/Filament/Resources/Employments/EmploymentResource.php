<?php

namespace App\Filament\Resources\Employments;

use App\Filament\Resources\Employments\Pages\CreateEmployment;
use App\Filament\Resources\Employments\Pages\EditEmployment;
use App\Filament\Resources\Employments\Pages\ListEmployments;
use App\Filament\Resources\Employments\Schemas\EmploymentForm;
use App\Filament\Resources\Employments\Tables\EmploymentsTable;
use Modules\Employment\Models\EmploymentHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class EmploymentResource extends Resource
{
    use HasPageShield;
    
    protected static ?string $model = EmploymentHistory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;
    
    protected static ?string $navigationLabel = 'Riwayat Pekerjaan';
    
    protected static ?int $navigationSort = 20;

    public static function getNavigationGroup(): ?string
    {
        return 'Data Alumni';
    }

    public static function form(Schema $schema): Schema
    {
        return EmploymentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmploymentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployments::route('/'),
            'create' => CreateEmployment::route('/create'),
            'edit' => EditEmployment::route('/{record}/edit'),
        ];
    }
}
