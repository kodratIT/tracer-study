<?php

namespace Modules\Reports\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Reports\Models\Report;
use Modules\Reports\Exports\BanPtReportExport;
use Modules\Survey\Models\SurveyResponse;
use Modules\Survey\Models\TracerStudySession;
use Modules\Alumni\Models\Alumni;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BanPtReportService
{
    /**
     * Generate employment statistics report
     */
    public function generateEmploymentStatistics(TracerStudySession $session, array $parameters = []): array
    {
        $responses = $this->getSessionResponses($session, $parameters);
        
        $employmentData = $responses->map(function ($response) {
            $alumni = $response->alumni;
            $employment = $alumni->employmentHistories()->latest()->first();
            
            return [
                'alumni_id' => $alumni->alumni_id,
                'name' => $alumni->name,
                'graduation_year' => $alumni->graduation_year,
                'program' => $alumni->program->program_name ?? 'N/A',
                'is_employed' => $employment ? true : false,
                'employment_status' => $employment ? 'employed' : 'unemployed',
                'job_title' => $employment->job_title ?? null,
                'salary_range' => $employment->salary_range ?? null,
                'contract_type' => $employment->contract_type ?? null,
            ];
        });

        $totalAlumni = $employmentData->count();
        $employedAlumni = $employmentData->where('is_employed', true)->count();
        $unemployedAlumni = $totalAlumni - $employedAlumni;
        $employmentRate = $totalAlumni > 0 ? round(($employedAlumni / $totalAlumni) * 100, 2) : 0;

        // Employment by contract type
        $contractTypes = $employmentData->where('is_employed', true)
            ->groupBy('contract_type')
            ->map(function ($group) {
                return $group->count();
            });

        // Employment by program
        $programStats = $employmentData->groupBy('program')
            ->map(function ($group) {
                $total = $group->count();
                $employed = $group->where('is_employed', true)->count();
                return [
                    'total' => $total,
                    'employed' => $employed,
                    'rate' => $total > 0 ? round(($employed / $total) * 100, 2) : 0,
                ];
            });

        return [
            'summary' => [
                'total_alumni' => $totalAlumni,
                'employed_alumni' => $employedAlumni,
                'unemployed_alumni' => $unemployedAlumni,
                'employment_rate' => $employmentRate,
            ],
            'contract_types' => $contractTypes,
            'program_statistics' => $programStats,
            'raw_data' => $employmentData,
            'generated_at' => now(),
        ];
    }

    /**
     * Generate waiting period analysis (masa tunggu kerja)
     */
    public function generateWaitingPeriodAnalysis(TracerStudySession $session, array $parameters = []): array
    {
        $responses = $this->getSessionResponses($session, $parameters);
        
        $waitingPeriods = [];
        foreach ($responses as $response) {
            $alumni = $response->alumni;
            $employment = $alumni->employmentHistories()->oldest()->first();
            
            if ($employment) {
                $graduationDate = Carbon::create($alumni->graduation_year, 7, 1); // Assume July graduation
                $employmentDate = Carbon::parse($employment->start_date);
                $waitingMonths = $graduationDate->diffInMonths($employmentDate);
                
                $waitingPeriods[] = [
                    'alumni_id' => $alumni->alumni_id,
                    'name' => $alumni->name,
                    'graduation_year' => $alumni->graduation_year,
                    'program' => $alumni->program->program_name ?? 'N/A',
                    'waiting_months' => $waitingMonths,
                    'first_job_title' => $employment->job_title,
                ];
            }
        }

        $waitingCollection = collect($waitingPeriods);
        $averageWaiting = $waitingCollection->avg('waiting_months');
        
        // Categorize waiting periods
        $categories = [
            '0_months' => $waitingCollection->where('waiting_months', 0)->count(),
            '1_3_months' => $waitingCollection->whereBetween('waiting_months', [1, 3])->count(),
            '4_6_months' => $waitingCollection->whereBetween('waiting_months', [4, 6])->count(),
            '7_12_months' => $waitingCollection->whereBetween('waiting_months', [7, 12])->count(),
            'over_12_months' => $waitingCollection->where('waiting_months', '>', 12)->count(),
        ];

        // By program analysis
        $programAnalysis = $waitingCollection->groupBy('program')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'average_waiting' => round($group->avg('waiting_months'), 2),
                    'min_waiting' => $group->min('waiting_months'),
                    'max_waiting' => $group->max('waiting_months'),
                ];
            });

        return [
            'summary' => [
                'total_with_employment' => $waitingCollection->count(),
                'average_waiting_months' => round($averageWaiting, 2),
                'median_waiting_months' => $waitingCollection->median('waiting_months'),
            ],
            'categories' => $categories,
            'program_analysis' => $programAnalysis,
            'raw_data' => $waitingPeriods,
            'generated_at' => now(),
        ];
    }

    /**
     * Generate job relevance analysis
     */
    public function generateJobRelevanceAnalysis(TracerStudySession $session, array $parameters = []): array
    {
        $responses = $this->getSessionResponses($session, $parameters);
        
        // This would typically analyze survey answers about job relevance
        // For now, we'll create a basic analysis based on job titles and study programs
        $relevanceData = [];
        
        foreach ($responses as $response) {
            $alumni = $response->alumni;
            $employment = $alumni->employmentHistories()->latest()->first();
            
            if ($employment) {
                // Simple relevance matching based on keywords
                $relevanceScore = $this->calculateJobRelevance(
                    $alumni->program->program_name ?? '',
                    $employment->job_title
                );
                
                $relevanceData[] = [
                    'alumni_id' => $alumni->alumni_id,
                    'name' => $alumni->name,
                    'program' => $alumni->program->program_name ?? 'N/A',
                    'job_title' => $employment->job_title,
                    'relevance_score' => $relevanceScore,
                    'relevance_category' => $this->getRelevanceCategory($relevanceScore),
                ];
            }
        }

        $relevanceCollection = collect($relevanceData);
        
        $categories = [
            'very_relevant' => $relevanceCollection->where('relevance_category', 'very_relevant')->count(),
            'relevant' => $relevanceCollection->where('relevance_category', 'relevant')->count(),
            'somewhat_relevant' => $relevanceCollection->where('relevance_category', 'somewhat_relevant')->count(),
            'not_relevant' => $relevanceCollection->where('relevance_category', 'not_relevant')->count(),
        ];

        $averageRelevance = $relevanceCollection->avg('relevance_score');

        return [
            'summary' => [
                'total_analyzed' => $relevanceCollection->count(),
                'average_relevance_score' => round($averageRelevance, 2),
                'high_relevance_percentage' => round(($categories['very_relevant'] + $categories['relevant']) / $relevanceCollection->count() * 100, 2),
            ],
            'categories' => $categories,
            'raw_data' => $relevanceData,
            'generated_at' => now(),
        ];
    }

    /**
     * Generate comprehensive BAN-PT standard report
     */
    public function generateBanPtStandardReport(TracerStudySession $session, array $parameters = []): array
    {
        return [
            'employment_statistics' => $this->generateEmploymentStatistics($session, $parameters),
            'waiting_period_analysis' => $this->generateWaitingPeriodAnalysis($session, $parameters),
            'job_relevance_analysis' => $this->generateJobRelevanceAnalysis($session, $parameters),
            'response_statistics' => $this->generateResponseStatistics($session, $parameters),
            'generated_at' => now(),
            'session_info' => [
                'session_id' => $session->session_id,
                'year' => $session->year,
                'title' => $session->display_name,
                'period' => $session->start_date->format('d/m/Y') . ' - ' . $session->end_date->format('d/m/Y'),
            ],
        ];
    }

    /**
     * Generate response statistics
     */
    public function generateResponseStatistics(TracerStudySession $session, array $parameters = []): array
    {
        $totalAlumni = Alumni::count(); // You might want to filter by graduation year
        $totalResponses = $session->total_responses_count;
        $completedResponses = $session->completed_responses_count;
        $partialResponses = $session->partial_responses_count;
        
        $responseRate = $totalAlumni > 0 ? round(($totalResponses / $totalAlumni) * 100, 2) : 0;
        $completionRate = $totalResponses > 0 ? round(($completedResponses / $totalResponses) * 100, 2) : 0;

        return [
            'total_alumni' => $totalAlumni,
            'total_responses' => $totalResponses,
            'completed_responses' => $completedResponses,
            'partial_responses' => $partialResponses,
            'response_rate' => $responseRate,
            'completion_rate' => $completionRate,
        ];
    }

    /**
     * Get filtered survey responses for a session
     */
    private function getSessionResponses(TracerStudySession $session, array $parameters = []): Collection
    {
        $query = SurveyResponse::where('session_id', $session->session_id)
            ->with(['alumni.program.department.faculty.campus', 'alumni.employmentHistories']);

        // Apply filters based on parameters
        if (!empty($parameters['graduation_years'])) {
            $query->whereHas('alumni', function ($q) use ($parameters) {
                $q->whereIn('graduation_year', $parameters['graduation_years']);
            });
        }

        if (!empty($parameters['programs'])) {
            $query->whereHas('alumni', function ($q) use ($parameters) {
                $q->whereIn('program_id', $parameters['programs']);
            });
        }

        if (!empty($parameters['completion_status'])) {
            $query->whereIn('completion_status', $parameters['completion_status']);
        }

        return $query->get();
    }

    /**
     * Calculate job relevance score based on program and job title
     */
    private function calculateJobRelevance(string $program, string $jobTitle): float
    {
        $program = strtolower($program);
        $jobTitle = strtolower($jobTitle);
        
        $relevanceMap = [
            'teknik informatika' => ['software', 'developer', 'programmer', 'engineer', 'system', 'IT', 'tech'],
            'ilmu komputer' => ['data', 'analyst', 'scientist', 'research', 'algorithm', 'AI', 'machine learning'],
            'sistem informasi' => ['business analyst', 'system analyst', 'project manager', 'consultant'],
        ];

        $score = 0;
        foreach ($relevanceMap as $studyField => $keywords) {
            if (str_contains($program, $studyField)) {
                foreach ($keywords as $keyword) {
                    if (str_contains($jobTitle, strtolower($keyword))) {
                        $score += 0.2;
                    }
                }
            }
        }

        return min($score, 1.0); // Cap at 1.0
    }

    /**
     * Get relevance category based on score
     */
    private function getRelevanceCategory(float $score): string
    {
        if ($score >= 0.8) return 'very_relevant';
        if ($score >= 0.6) return 'relevant';
        if ($score >= 0.4) return 'somewhat_relevant';
        return 'not_relevant';
    }

    /**
     * Create a new report entry
     */
    public function createReport(array $data): Report
    {
        return Report::create([
            'title' => $data['title'],
            'report_type' => $data['report_type'],
            'session_id' => $data['session_id'] ?? null,
            'parameters' => $data['parameters'] ?? [],
            'file_format' => $data['file_format'] ?? Report::FORMAT_PDF,
            'status' => Report::STATUS_PENDING,
        ]);
    }

    /**
     * Generate and save report
     */
    public function generateReport(Report $report): void
    {
        try {
            $report->update(['status' => Report::STATUS_GENERATING]);
            
            $session = $report->session;
            $parameters = $report->parameters ?? [];
            
            $data = match($report->report_type) {
                'employment_statistics' => $this->generateEmploymentStatistics($session, $parameters),
                'waiting_period' => $this->generateWaitingPeriodAnalysis($session, $parameters),
                'job_relevance' => $this->generateJobRelevanceAnalysis($session, $parameters),
                'ban_pt_standard' => $this->generateBanPtStandardReport($session, $parameters),
                default => throw new \Exception("Unsupported report type: {$report->report_type}"),
            };

            // Save the report data to metadata
            $report->update([
                'metadata' => array_merge($report->metadata ?? [], ['report_data' => $data]),
            ]);

            // Generate and save the actual file
            $filePath = $this->generateReportFile($report, $data);
            
            $report->update([
                'file_path' => $filePath,
                'file_size' => Storage::size($filePath),
                'status' => Report::STATUS_COMPLETED,
                'completed_at' => now(),
            ]);
            
        } catch (\Exception $e) {
            $report->update([
                'status' => Report::STATUS_FAILED,
                'error_message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Generate the actual report file (PDF/Excel/CSV)
     */
    protected function generateReportFile(Report $report, array $data): string
    {
        $fileName = $this->generateFileName($report);
        $filePath = "reports/{$fileName}";

        // Ensure reports directory exists
        if (!Storage::exists('reports')) {
            Storage::makeDirectory('reports');
        }

        switch ($report->format) {
            case Report::FORMAT_PDF:
                $this->generatePdfFile($report, $data, $filePath);
                break;
                
            case Report::FORMAT_EXCEL:
                $this->generateExcelFile($report, $data, $filePath);
                break;
                
            case Report::FORMAT_CSV:
                $this->generateCsvFile($report, $data, $filePath);
                break;
                
            default:
                throw new \Exception("Unsupported file format: {$report->format}");
        }

        return $filePath;
    }

    /**
     * Generate PDF file
     */
    protected function generatePdfFile(Report $report, array $data, string $filePath): void
    {
        // Prepare data for PDF template
        $reportData = $data['raw_data'] ?? [];
        $summary = $data['summary'] ?? [];
        
        // Convert data to table format for PDF
        $tableData = $this->prepareDataForPdf($report, $reportData);
        
        $pdf = Pdf::loadView('reports::pdf.report-template', [
            'report' => $report,
            'data' => $tableData,
            'summary' => $summary,
        ]);
        
        $pdf->setPaper('A4', 'portrait');
        Storage::put($filePath, $pdf->output());
    }

    /**
     * Generate Excel file
     */
    protected function generateExcelFile(Report $report, array $data, string $filePath): void
    {
        $reportData = $data['raw_data'] ?? [];
        $tableData = $this->prepareDataForExcel($report, $reportData);
        
        Excel::store(new BanPtReportExport($report, $tableData), $filePath);
    }

    /**
     * Generate CSV file
     */
    protected function generateCsvFile(Report $report, array $data, string $filePath): void
    {
        $reportData = $data['raw_data'] ?? [];
        $tableData = $this->prepareDataForExcel($report, $reportData); // Same format as Excel
        
        Excel::store(new BanPtReportExport($report, $tableData), $filePath, null, \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Prepare data for PDF display
     */
    protected function prepareDataForPdf(Report $report, array $data): array
    {
        if (empty($data)) {
            return [];
        }

        switch ($report->type) {
            case 'employment_statistics':
                // Group by program for summary
                $programs = collect($data)->groupBy('program');
                return $programs->map(function ($alumni, $program) {
                    $total = $alumni->count();
                    $employed = $alumni->where('is_employed', true)->count();
                    return [
                        'program' => $program,
                        'total_alumni' => $total,
                        'bekerja' => $employed,
                        'tidak_bekerja' => $total - $employed,
                        'persentase_kerja' => $total > 0 ? round(($employed / $total) * 100, 1) . '%' : '0%',
                    ];
                })->values()->toArray();

            case 'waiting_period':
                $programs = collect($data)->groupBy('program');
                return $programs->map(function ($alumni, $program) {
                    $waitingPeriods = $alumni->pluck('waiting_months')->filter();
                    return [
                        'program' => $program,
                        'total_alumni' => $alumni->count(),
                        'avg_waiting_period' => $waitingPeriods->avg() ? round($waitingPeriods->avg(), 1) : 0,
                        'median_waiting_period' => $waitingPeriods->median() ?? 0,
                        'min_waiting' => $waitingPeriods->min() ?? 0,
                        'max_waiting' => $waitingPeriods->max() ?? 0,
                    ];
                })->values()->toArray();

            default:
                return array_slice($data, 0, 50); // Limit to 50 rows for PDF
        }
    }

    /**
     * Prepare data for Excel export
     */
    protected function prepareDataForExcel(Report $report, array $data): array
    {
        if (empty($data)) {
            return [['No data available']];
        }

        // Return raw data for Excel (can handle more rows)
        return $data;
    }

    /**
     * Generate unique filename for report
     */
    protected function generateFileName(Report $report): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $extension = match($report->format) {
            Report::FORMAT_PDF => 'pdf',
            Report::FORMAT_EXCEL => 'xlsx',
            Report::FORMAT_CSV => 'csv',
            default => 'pdf',
        };
        
        $title = preg_replace('/[^A-Za-z0-9\-_]/', '_', $report->title);
        return "report_{$report->report_id}_{$title}_{$timestamp}.{$extension}";
    }
}
