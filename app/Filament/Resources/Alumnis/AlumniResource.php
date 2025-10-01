<?php

namespace App\Filament\Resources\Alumnis;

use App\Filament\Resources\Alumnis\Pages\CreateAlumni;
use App\Filament\Resources\Alumnis\Pages\EditAlumni;
use App\Filament\Resources\Alumnis\Pages\ListAlumnis;
use App\Filament\Resources\Alumnis\Schemas\AlumniForm;
use App\Filament\Resources\Alumnis\Tables\AlumnisTable;
use Modules\Alumni\Models\Alumni;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AlumniResource extends Resource
{
    protected static ?string $model = Alumni::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    
    protected static ?string $navigationLabel = 'Alumni';
    

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return 'Data Alumni';
    }

    public static function form(Schema $schema): Schema
    {
        return AlumniForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlumnisTable::configure($table);
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
            'index' => ListAlumnis::route('/'),
            'create' => CreateAlumni::route('/create'),
            'edit' => EditAlumni::route('/{record}/edit'),
        ];
    }
}
