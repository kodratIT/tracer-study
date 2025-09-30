<?php

namespace App\Filament\Resources\SurveyResponses;

use App\Filament\Resources\SurveyResponses\Pages\ListSurveyResponses;
use App\Filament\Resources\SurveyResponses\Pages\ViewSurveyResponse;
use App\Filament\Resources\SurveyResponses\Schemas\SurveyResponseForm;
use App\Filament\Resources\SurveyResponses\Tables\SurveyResponsesTable;
use Modules\Survey\Models\SurveyResponse;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SurveyResponseResource extends Resource
{
    protected static ?string $model = SurveyResponse::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
    
    protected static ?string $navigationLabel = 'Monitor Respons';
    
    protected static ?int $navigationSort = 50;

    protected static ?string $recordTitleAttribute = 'response_id';

    public static function form(Schema $schema): Schema
    {
        return SurveyResponseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SurveyResponsesTable::configure($table);
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
            'index' => ListSurveyResponses::route('/'),
            'view' => ViewSurveyResponse::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Responses are created by alumni filling surveys
    }

    public static function canEdit($record): bool
    {
        return false; // Responses should not be edited through admin panel
    }

    public static function canDelete($record): bool
    {
        return false; // Responses should not be deleted
    }
}
