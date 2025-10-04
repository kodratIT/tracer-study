<?php

namespace App\Services\Reports;

use Modules\Reports\Models\Report;
use Modules\Survey\Models\TracerStudySession;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportGeneratorService
{
    /**
     * Generate report based on type
     */
    public function generate(Report $report): bool
    {
        try {
            // Mark as generating
            $report->update(['status' => Report::STATUS_GENERATING]);

            // Get generator based on type
            $generator = $this->getGenerator($report->report_type);
            
            if (!$generator) {
                throw new \Exception("Report generator not found for type: {$report->report_type}");
            }

            // Generate data
            $data = $generator->generate($report);

            // Export based on format
            $exporter = $this->getExporter($report->file_format);
            $filePath = $exporter->export($report, $data);

            // Mark as completed
            $report->markAsCompleted($filePath);
            $report->setExpiration(30); // 30 days

            return true;

        } catch (\Exception $e) {
            $report->markAsFailed($e->getMessage());
            \Log::error("Report generation failed: {$e->getMessage()}", [
                'report_id' => $report->report_id,
                'type' => $report->report_type,
            ]);
            return false;
        }
    }

    /**
     * Get generator instance based on type
     */
    protected function getGenerator(string $type)
    {
        $generators = [
            'response_rate' => Generators\ResponseRateGenerator::class,
            'employment_statistics' => Generators\EmploymentStatisticsGenerator::class,
            'waiting_period' => Generators\WaitingPeriodGenerator::class,
            'job_relevance' => Generators\JobRelevanceGenerator::class,
            'salary_analysis' => Generators\SalaryAnalysisGenerator::class,
            'competency_analysis' => Generators\CompetencyAnalysisGenerator::class,
            'geographic_distribution' => Generators\GeographicDistributionGenerator::class,
            'ban_pt_standard' => Generators\BanPTStandardGenerator::class,
        ];

        $generatorClass = $generators[$type] ?? null;
        
        return $generatorClass ? new $generatorClass() : null;
    }

    /**
     * Get exporter instance based on format
     */
    protected function getExporter(string $format)
    {
        $exporters = [
            'pdf' => Exporters\PDFExporter::class,
            'excel' => Exporters\ExcelExporter::class,
            'csv' => Exporters\CSVExporter::class,
        ];

        $exporterClass = $exporters[$format] ?? Exporters\PDFExporter::class;
        
        return new $exporterClass();
    }

    /**
     * Get report title based on type
     */
    public static function getDefaultTitle(string $type, ?TracerStudySession $session = null): string
    {
        $titles = [
            'response_rate' => 'Laporan Response Rate',
            'employment_statistics' => 'Laporan Statistik Ketenagakerjaan',
            'waiting_period' => 'Laporan Masa Tunggu Kerja',
            'job_relevance' => 'Laporan Relevansi Pekerjaan',
            'salary_analysis' => 'Laporan Analisis Gaji',
            'competency_analysis' => 'Laporan Analisis Kompetensi',
            'geographic_distribution' => 'Laporan Distribusi Geografis',
            'ban_pt_standard' => 'Laporan Standar BAN-PT',
        ];

        $title = $titles[$type] ?? 'Laporan Tracer Study';
        
        if ($session) {
            $title .= " - {$session->title}";
        }
        
        $title .= " - " . now()->format('d M Y');
        
        return $title;
    }

    /**
     * Clean up expired reports
     */
    public static function cleanupExpiredReports(): int
    {
        $expiredReports = Report::where('expires_at', '<', now())
                               ->where('status', Report::STATUS_COMPLETED)
                               ->get();

        $count = 0;
        foreach ($expiredReports as $report) {
            // Delete file
            if ($report->file_path && Storage::exists($report->file_path)) {
                Storage::delete($report->file_path);
            }

            // Update status
            $report->update(['status' => Report::STATUS_EXPIRED]);
            $count++;
        }

        return $count;
    }
}
