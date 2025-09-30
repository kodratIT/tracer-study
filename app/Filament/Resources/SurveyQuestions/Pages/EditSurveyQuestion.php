<?php

namespace App\Filament\Resources\SurveyQuestions\Pages;

use App\Filament\Resources\SurveyQuestions\SurveyQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurveyQuestion extends EditRecord
{
    protected static string $resource = SurveyQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus'),
        ];
    }
}
