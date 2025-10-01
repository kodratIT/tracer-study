<?php

namespace Modules\Reports\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class ComprehensiveReportExport implements WithMultipleSheets, WithTitle
{
    protected array $filters;
    protected ?int $sessionId;

    public function __construct(array $filters = [], ?int $sessionId = null)
    {
        $this->filters = $filters;
        $this->sessionId = $sessionId;
    }

    public function sheets(): array
    {
        return [
            'alumni' => new AlumniExport($this->filters),
            'employment' => new EmploymentHistoryExport($this->filters),
            'survey_responses' => new SurveyResponseExport($this->filters, $this->sessionId),
            'summary' => new SummaryStatsExport($this->filters, $this->sessionId),
        ];
    }

    public function title(): string
    {
        return 'Comprehensive Report';
    }
}
