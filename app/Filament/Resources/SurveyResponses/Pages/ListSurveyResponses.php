<?php

namespace App\Filament\Resources\SurveyResponses\Pages;

use App\Filament\Resources\SurveyResponses\SurveyResponseResource;
use App\Filament\Resources\SurveyResponses\Widgets\SurveyResponseStatsWidget;
use Filament\Resources\Pages\ListRecords;
use Modules\Reports\Actions\ExportAction;

class ListSurveyResponses extends ListRecords
{
    protected static string $resource = SurveyResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::surveyResponses()
                ->label('Export Survey Responses'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SurveyResponseStatsWidget::class,
        ];
    }
}
