<?php

namespace App\Filament\Resources\SurveyResponses\Pages;

use App\Filament\Resources\SurveyResponses\SurveyResponseResource;
use App\Filament\Resources\SurveyResponses\Widgets\SurveyResponseStatsWidget;
use Filament\Resources\Pages\ListRecords;

class ListSurveyResponses extends ListRecords
{
    protected static string $resource = SurveyResponseResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            SurveyResponseStatsWidget::class,
        ];
    }
}
