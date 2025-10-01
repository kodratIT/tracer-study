<?php

namespace Modules\Reports\Services;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Modules\Reports\Exports\AlumniExport;
use Modules\Reports\Exports\EmploymentHistoryExport;
use Modules\Reports\Exports\SurveyResponseExport;
use Modules\Reports\Exports\ComprehensiveReportExport;
use Modules\Reports\Exports\BanPtReportExport;

class ExportService
{
    /**
     * Export alumni data to Excel
     */
    public function exportAlumniToExcel(array $filters = [], ?string $filename = null): string
    {
        $filename = $filename ?? 'alumni_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $filePath = 'exports/' . $filename;
        
        Excel::store(new AlumniExport($filters), $filePath);
        
        return $filePath;
    }

    /**
     * Export alumni data to PDF
     */
    public function exportAlumniToPdf(array $filters = [], ?string $filename = null): string
    {
        $filename = $filename ?? 'alumni_export_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        $filePath = 'exports/' . $filename;
        
        // Get alumni data for PDF
        $alumniQuery = (new AlumniExport($filters))->query();
        $alumni = $alumniQuery->get();
        
        $pdf = Pdf::loadView('reports::pdf.alumni-export', [
            'alumni' => $alumni,
            'filters' => $filters,
            'generated_at' => now(),
        ]);
        
        $pdf->setPaper('A4', 'landscape'); // Landscape for more columns
        Storage::put($filePath, $pdf->output());
        
        return $filePath;
    }

    /**
     * Export employment history to Excel
     */
    public function exportEmploymentToExcel(array $filters = [], ?string $filename = null): string
    {
        $filename = $filename ?? 'employment_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $filePath = 'exports/' . $filename;
        
        Excel::store(new EmploymentHistoryExport($filters), $filePath);
        
        return $filePath;
    }

    /**
     * Export survey responses to Excel
     */
    public function exportSurveyResponsesToExcel(?int $sessionId = null, array $filters = [], ?string $filename = null): string
    {
        $filename = $filename ?? 'survey_responses_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $filePath = 'exports/' . $filename;
        
        Excel::store(new SurveyResponseExport($filters, $sessionId), $filePath);
        
        return $filePath;
    }

    /**
     * Export comprehensive report with multiple sheets
     */
    public function exportComprehensiveReport(?int $sessionId = null, array $filters = [], ?string $filename = null): string
    {
        $filename = $filename ?? 'comprehensive_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $filePath = 'exports/' . $filename;
        
        Excel::store(new ComprehensiveReportExport($filters, $sessionId), $filePath);
        
        return $filePath;
    }

    /**
     * Export data based on type and format
     */
    public function exportData(string $type, string $format = 'excel', array $filters = [], ?int $sessionId = null): string
    {
        // Ensure exports directory exists
        if (!Storage::exists('exports')) {
            Storage::makeDirectory('exports');
        }

        $method = match($type) {
            'alumni' => $format === 'pdf' ? 'exportAlumniToPdf' : 'exportAlumniToExcel',
            'employment' => 'exportEmploymentToExcel',
            'survey_responses' => 'exportSurveyResponsesToExcel',
            'comprehensive' => 'exportComprehensiveReport',
            default => throw new \InvalidArgumentException("Unsupported export type: {$type}"),
        };

        if ($type === 'survey_responses' || $type === 'comprehensive') {
            return $this->$method($sessionId, $filters);
        }
        
        return $this->$method($filters);
    }

    /**
     * Get download URL for exported file
     */
    public function getDownloadUrl(string $filePath): string
    {
        return route('reports.export.download', ['file' => basename($filePath)]);
    }

    /**
     * Clean up old export files (older than 24 hours)
     */
    public function cleanupOldExports(): int
    {
        $files = Storage::files('exports');
        $deletedCount = 0;
        
        foreach ($files as $file) {
            $lastModified = Storage::lastModified($file);
            if ($lastModified < now()->subDay()->timestamp) {
                Storage::delete($file);
                $deletedCount++;
            }
        }
        
        return $deletedCount;
    }

    /**
     * Get export file info
     */
    public function getFileInfo(string $filePath): array
    {
        if (!Storage::exists($filePath)) {
            throw new \Exception("Export file not found: {$filePath}");
        }
        
        return [
            'path' => $filePath,
            'size' => Storage::size($filePath),
            'size_human' => $this->formatBytes(Storage::size($filePath)),
            'last_modified' => Storage::lastModified($filePath),
            'download_url' => $this->getDownloadUrl($filePath),
        ];
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
