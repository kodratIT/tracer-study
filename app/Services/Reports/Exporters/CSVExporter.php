<?php

namespace App\Services\Reports\Exporters;

use Modules\Reports\Models\Report;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CSVExporter
{
    /**
     * Export report to CSV
     */
    public function export(Report $report, array $data): string
    {
        // Generate filename
        $filename = $this->generateFilename($report);
        
        // Get data for CSV
        $csvData = $this->prepareData($report, $data);
        
        // Create CSV content
        $content = $this->arrayToCsv($csvData);
        
        // Save to storage
        $path = "reports/csv/{$filename}";
        Storage::put($path, $content);
        
        return $path;
    }

    /**
     * Generate unique filename
     */
    protected function generateFilename(Report $report): string
    {
        $slug = Str::slug($report->title);
        $timestamp = now()->format('Ymd_His');
        
        return "{$slug}_{$timestamp}.csv";
    }

    /**
     * Prepare data based on report type
     */
    protected function prepareData(Report $report, array $data): array
    {
        // For CSV, we'll export the detailed data
        if (isset($data['details']) && is_array($data['details'])) {
            return $data['details'];
        }
        
        // Fallback to summary
        if (isset($data['summary']) && is_array($data['summary'])) {
            return [$data['summary']];
        }
        
        return [];
    }

    /**
     * Convert array to CSV string
     */
    protected function arrayToCsv(array $data): string
    {
        if (empty($data)) {
            return '';
        }

        $output = fopen('php://temp', 'r+');
        
        // Write header
        $firstRow = $data[0];
        fputcsv($output, array_keys($firstRow));
        
        // Write data rows
        foreach ($data as $row) {
            fputcsv($output, array_values($row));
        }
        
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        
        return $csv;
    }
}
