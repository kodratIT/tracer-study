<?php

namespace App\Services\Reports\Exporters;

use Modules\Reports\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PDFExporter
{
    /**
     * Export report to PDF
     */
    public function export(Report $report, array $data): string
    {
        // Generate filename
        $filename = $this->generateFilename($report);
        
        // Select view based on report type
        $view = $this->getViewName($report->report_type);
        
        // Generate PDF
        $pdf = Pdf::loadView($view, array_merge($data, [
            'report' => $report,
        ]))
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
        ]);

        // Save to storage
        $path = "reports/pdf/{$filename}";
        Storage::put($path, $pdf->output());
        
        return $path;
    }

    /**
     * Generate unique filename
     */
    protected function generateFilename(Report $report): string
    {
        $slug = Str::slug($report->title);
        $timestamp = now()->format('Ymd_His');
        
        return "{$slug}_{$timestamp}.pdf";
    }

    /**
     * Get view name based on report type
     */
    protected function getViewName(string $reportType): string
    {
        $views = [
            'response_rate' => 'reports.pdf.response-rate',
            'employment_statistics' => 'reports.pdf.employment-statistics',
            'waiting_period' => 'reports.pdf.waiting-period',
            'job_relevance' => 'reports.pdf.job-relevance',
            'salary_analysis' => 'reports.pdf.salary-analysis',
            'competency_analysis' => 'reports.pdf.competency-analysis',
            'geographic_distribution' => 'reports.pdf.geographic-distribution',
            'ban_pt_standard' => 'reports.pdf.ban-pt-standard',
        ];

        return $views[$reportType] ?? 'reports.pdf.default';
    }
}
