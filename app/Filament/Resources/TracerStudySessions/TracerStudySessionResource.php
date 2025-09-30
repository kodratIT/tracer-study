<?php

namespace App\Filament\Resources\TracerStudySessions;

use App\Filament\Resources\TracerStudySessions\Pages\CreateTracerStudySession;
use App\Filament\Resources\TracerStudySessions\Pages\EditTracerStudySession;
use App\Filament\Resources\TracerStudySessions\Pages\ListTracerStudySessions;
use App\Filament\Resources\TracerStudySessions\Schemas\TracerStudySessionForm;
use App\Filament\Resources\TracerStudySessions\Tables\TracerStudySessionsTable;
use Modules\Survey\Models\TracerStudySession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TracerStudySessionResource extends Resource
{
    protected static ?string $model = TracerStudySession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    
    protected static ?string $navigationLabel = 'Sesi Tracer Study';
    
    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return TracerStudySessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TracerStudySessionsTable::configure($table);
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
            'index' => ListTracerStudySessions::route('/'),
            'create' => CreateTracerStudySession::route('/create'),
            'edit' => EditTracerStudySession::route('/{record}/edit'),
        ];
    }
}
