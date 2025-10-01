<?php

namespace Modules\Reports\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\CheckboxList;
use Filament\Notifications\Notification;
use Modules\Reports\Services\ExportService;
use Modules\Education\Models\Program;

class ExportAction
{
    /**
     * Create Alumni Export Action
     */
    public static function alumni(): Action
    {
        return Action::make('export_alumni')
            ->label('Export Alumni')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->form([
                Select::make('format')
                    ->label('Export Format')
                    ->options([
                        'excel' => 'Excel (.xlsx)',
                        'pdf' => 'PDF',
                    ])
                    ->default('excel')
                    ->required(),
                
                CheckboxList::make('graduation_years')
                    ->label('Filter by Graduation Year')
                    ->options(function () {
                        $currentYear = date('Y');
                        $years = [];
                        for ($year = $currentYear; $year >= $currentYear - 15; $year--) {
                            $years[$year] = (string) $year;
                        }
                        return $years;
                    })
                    ->columns(4),
                
                CheckboxList::make('program_ids')
                    ->label('Filter by Program')
                    ->options(function () {
                        return Program::select('program_id', 'program_name')
                            ->whereHas('alumni')
                            ->orderBy('program_name')
                            ->pluck('program_name', 'program_id');
                    })
                    ->searchable(),
            ])
            ->action(function (array $data) {
                try {
                    $exportService = app(ExportService::class);
                    
                    $filters = [
                        'graduation_years' => $data['graduation_years'] ?? [],
                        'program_ids' => $data['program_ids'] ?? [],
                    ];
                    
                    $filePath = $exportService->exportData('alumni', $data['format'], $filters);
                    $fileInfo = $exportService->getFileInfo($filePath);
                    
                    Notification::make()
                        ->title('Export Successful!')
                        ->body("Alumni data exported successfully. File size: {$fileInfo['size_human']} - [Download here]({$fileInfo['download_url']})")
                        ->success()
                        ->send();
                        
                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Export Failed')
                        ->body('Failed to export alumni data: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    /**
     * Create Employment History Export Action
     */
    public static function employment(): Action
    {
        return Action::make('export_employment')
            ->label('Export Employment History')
            ->icon('heroicon-o-briefcase')
            ->color('warning')
            ->form([
                CheckboxList::make('graduation_years')
                    ->label('Filter by Graduation Year')
                    ->options(function () {
                        $currentYear = date('Y');
                        $years = [];
                        for ($year = $currentYear; $year >= $currentYear - 15; $year--) {
                            $years[$year] = (string) $year;
                        }
                        return $years;
                    })
                    ->columns(4),
            ])
            ->action(function (array $data) {
                try {
                    $exportService = app(ExportService::class);
                    
                    $filters = [
                        'graduation_years' => $data['graduation_years'] ?? [],
                    ];
                    
                    $filePath = $exportService->exportData('employment', 'excel', $filters);
                    $fileInfo = $exportService->getFileInfo($filePath);
                    
                    Notification::make()
                        ->title('Export Successful!')
                        ->body("Employment data exported successfully. File size: {$fileInfo['size_human']} - [Download here]({$fileInfo['download_url']})")
                        ->success()
                        ->send();
                        
                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Export Failed')
                        ->body('Failed to export employment data: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    /**
     * Create Survey Responses Export Action
     */
    public static function surveyResponses(?int $defaultSessionId = null): Action
    {
        return Action::make('export_survey_responses')
            ->label('Export Survey Responses')
            ->icon('heroicon-o-clipboard-document-list')
            ->color('info')
            ->form([
                Select::make('session_id')
                    ->label('Tracer Study Session')
                    ->options(function () {
                        return \Modules\Survey\Models\TracerStudySession::select('session_id', 'year', 'start_date', 'end_date')
                            ->orderBy('year', 'desc')
                            ->get()
                            ->mapWithKeys(function ($session) {
                                $displayName = "Tracer Study {$session->year} ({$session->start_date->format('M d')} - {$session->end_date->format('M d')})";
                                return [$session->session_id => $displayName];
                            });
                    })
                    ->default($defaultSessionId)
                    ->required(),
                
                CheckboxList::make('completion_status')
                    ->label('Filter by Completion Status')
                    ->options([
                        'completed' => 'Completed',
                        'partial' => 'Partial',
                        'draft' => 'Draft',
                    ])
                    ->default(['completed', 'partial']),
            ])
            ->action(function (array $data) {
                try {
                    $exportService = app(ExportService::class);
                    
                    $filters = [
                        'completion_status' => $data['completion_status'] ?? [],
                    ];
                    
                    $filePath = $exportService->exportData('survey_responses', 'excel', $filters, $data['session_id']);
                    $fileInfo = $exportService->getFileInfo($filePath);
                    
                    Notification::make()
                        ->title('Export Successful!')
                        ->body("Survey responses exported successfully. File size: {$fileInfo['size_human']} - [Download here]({$fileInfo['download_url']})")
                        ->success()
                        ->send();
                        
                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Export Failed')
                        ->body('Failed to export survey responses: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    /**
     * Create Comprehensive Report Export Action
     */
    public static function comprehensive(?int $defaultSessionId = null): Action
    {
        return Action::make('export_comprehensive')
            ->label('Export Comprehensive Report')
            ->icon('heroicon-o-document-chart-bar')
            ->color('primary')
            ->form([
                Select::make('session_id')
                    ->label('Tracer Study Session')
                    ->options(function () {
                        return \Modules\Survey\Models\TracerStudySession::select('session_id', 'year', 'start_date', 'end_date')
                            ->orderBy('year', 'desc')
                            ->get()
                            ->mapWithKeys(function ($session) {
                                $displayName = "Tracer Study {$session->year} ({$session->start_date->format('M d')} - {$session->end_date->format('M d')})";
                                return [$session->session_id => $displayName];
                            });
                    })
                    ->default($defaultSessionId)
                    ->required(),
                
                CheckboxList::make('graduation_years')
                    ->label('Filter by Graduation Year')
                    ->options(function () {
                        $currentYear = date('Y');
                        $years = [];
                        for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                            $years[$year] = (string) $year;
                        }
                        return $years;
                    })
                    ->columns(4),
            ])
            ->action(function (array $data) {
                try {
                    $exportService = app(ExportService::class);
                    
                    $filters = [
                        'graduation_years' => $data['graduation_years'] ?? [],
                    ];
                    
                    $filePath = $exportService->exportData('comprehensive', 'excel', $filters, $data['session_id']);
                    $fileInfo = $exportService->getFileInfo($filePath);
                    
                    Notification::make()
                        ->title('Comprehensive Report Generated!')
                        ->body("Multi-sheet report created successfully. File size: {$fileInfo['size_human']} - [Download here]({$fileInfo['download_url']})")
                        ->success()
                        ->send();
                        
                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Export Failed')
                        ->body('Failed to generate comprehensive report: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
