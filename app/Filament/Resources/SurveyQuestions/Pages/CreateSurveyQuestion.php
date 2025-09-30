<?php

namespace App\Filament\Resources\SurveyQuestions\Pages;

use App\Filament\Resources\SurveyQuestions\SurveyQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSurveyQuestion extends CreateRecord
{
    protected static string $resource = SurveyQuestionResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-set display_order if not provided
        if (empty($data['display_order'])) {
            $maxOrder = \Modules\Survey\Models\SurveyQuestion::where('session_id', $data['session_id'])
                ->max('display_order');
            $data['display_order'] = ($maxOrder ?? 0) + 1;
        }
        
        return $data;
    }
}
