<?php

namespace App\Filament\Resources\Campuses;

use App\Filament\Resources\Campuses\Pages\CreateCampus;
use App\Filament\Resources\Campuses\Pages\EditCampus;
use App\Filament\Resources\Campuses\Pages\ListCampuses;
use App\Filament\Resources\Campuses\Schemas\CampusForm;
use App\Filament\Resources\Campuses\Tables\CampusesTable;
use Modules\Education\Models\Campus;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class CampusResource extends Resource
{
    use HasPageShield;
    
    protected static ?string $model = Campus::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;
    
    protected static ?string $navigationLabel = 'Campus';
    
    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return 'Struktur Pendidikan';
    }

    public static function form(Schema $schema): Schema
    {
        return CampusForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CampusesTable::configure($table);
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
            'index' => ListCampuses::route('/'),
            'create' => CreateCampus::route('/create'),
            'edit' => EditCampus::route('/{record}/edit'),
        ];
    }
}
