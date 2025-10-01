<?php

namespace Modules\Reports\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Modules\Reports\Actions\ExportAction;

class ReportsDashboard extends Page
{
    protected static string $navigationIcon = 'heroicon-o-chart-pie';
    
    protected static string $view = 'reports::filament.pages.reports-dashboard';
    
    protected static ?string $navigationLabel = 'Analytics Dashboard';
    
    protected static ?string $title = 'Tracer Study Analytics';
    
    protected static ?int $navigationSort = 70;
    
    protected static ?string $navigationGroup = null;

    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\Reports\Widgets\ReportStatsWidget::class,
            \App\Filament\Resources\SurveyResponses\Widgets\SurveyResponseStatsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::alumni()
                ->label('Export Alumni'),
            ExportAction::employment()
                ->label('Export Employment'),
            ExportAction::comprehensive()
                ->label('Comprehensive Report'),
        ];
    }

    public function getWidgets(): array
    {
        return [
            \Modules\Reports\Filament\Widgets\AlumniSurveyByYearChart::class,
            \Modules\Reports\Filament\Widgets\EmploymentStatusChart::class,
            \Modules\Reports\Filament\Widgets\SalaryDistributionChart::class,
            \Modules\Reports\Filament\Widgets\SkillDistributionChart::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return [
            'md' => 2,
            'xl' => 2,
        ];
    }
}
