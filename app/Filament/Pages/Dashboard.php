<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            // Main Stats - Always visible
            \App\Filament\Widgets\TracerStudyOverviewWidget::class,
            
            // Survey Response Stats
            \App\Filament\Resources\SurveyResponses\Widgets\SurveyResponseStatsWidget::class,
            
            // Alumni & Employment Summary
            \App\Filament\Widgets\AlumniEmploymentStatsWidget::class,
            
            // Quick Actions
            \App\Filament\Widgets\QuickActionsWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 3,
        ];
    }
}
