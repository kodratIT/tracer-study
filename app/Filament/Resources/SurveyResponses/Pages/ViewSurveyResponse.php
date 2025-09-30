<?php

namespace App\Filament\Resources\SurveyResponses\Pages;

use App\Filament\Resources\SurveyResponses\SurveyResponseResource;
use Filament\Resources\Pages\ViewRecord;

class ViewSurveyResponse extends ViewRecord
{
    protected static string $resource = SurveyResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No actions needed for viewing responses
        ];
    }

    public function getTitle(): string
    {
        return 'Detail Respons: ' . $this->record->alumni?->name ?? 'Unknown Alumni';
    }
}
