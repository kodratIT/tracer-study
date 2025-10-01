<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            \Filament\Widgets\AccountWidget::class,
            
            // Alumni and Survey Analytics
            \Modules\Reports\Filament\Widgets\AlumniSurveyByYearChart::class,
            \Modules\Reports\Filament\Widgets\EmploymentStatusChart::class,
            
            // Employment and Career Analytics  
            \Modules\Reports\Filament\Widgets\SalaryDistributionChart::class,
            \Modules\Reports\Filament\Widgets\SkillDistributionChart::class,
            
            // Additional widgets from resources
            \App\Filament\Resources\Reports\Widgets\ReportStatsWidget::class,
            \App\Filament\Resources\SurveyResponses\Widgets\SurveyResponseStatsWidget::class,
            
            \Filament\Widgets\FilamentInfoWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'md' => 2,
            'xl' => 3,
        ];
    }
}
