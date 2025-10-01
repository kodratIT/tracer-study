<?php

namespace Modules\Reports\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Reports\Models\Report;
use Modules\Survey\Models\TracerStudySession;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting Reports Database Seeding...');

        // Get or create tracer study session
        $session = TracerStudySession::first();
        if (!$session) {
            $session = TracerStudySession::create([
                'year' => 2024,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'description' => 'Tracer Study Alumni 2024 - Standar BAN-PT',
                'is_active' => true
            ]);
            $this->command->info('Created sample tracer study session');
        }

        // Create example reports
        $reports = [
            [
                'title' => 'Laporan Statistik Ketenagakerjaan Alumni 2024',
                'report_type' => 'employment_statistics',
                'session_id' => $session->session_id,
                'file_format' => Report::FORMAT_PDF,
                'status' => Report::STATUS_COMPLETED,
                'parameters' => [
                    'graduation_years' => [2022, 2023, 2024],
                    'include_charts' => true,
                    'include_raw_data' => false,
                ],
                'metadata' => [
                    'total_alumni_analyzed' => 150,
                    'employment_rate' => 85.5,
                    'response_rate' => 78.2,
                ],
                'generated_at' => now()->subDays(2),
                'expires_at' => now()->addDays(28),
            ],
            [
                'title' => 'Analisis Masa Tunggu Kerja Lulusan IT',
                'report_type' => 'waiting_period',
                'session_id' => $session->session_id,
                'file_format' => Report::FORMAT_EXCEL,
                'status' => Report::STATUS_COMPLETED,
                'parameters' => [
                    'graduation_years' => [2023, 2024],
                    'programs' => [1, 2], // Assuming IT-related programs
                    'include_charts' => true,
                ],
                'metadata' => [
                    'average_waiting_months' => 3.2,
                    'median_waiting_months' => 2.5,
                    'total_analyzed' => 87,
                ],
                'generated_at' => now()->subDays(5),
                'expires_at' => now()->addDays(25),
            ],
            [
                'title' => 'Laporan Relevansi Pekerjaan dengan Bidang Studi',
                'report_type' => 'job_relevance',
                'session_id' => $session->session_id,
                'file_format' => Report::FORMAT_PDF,
                'status' => Report::STATUS_COMPLETED,
                'parameters' => [
                    'completion_status' => ['completed'],
                    'include_charts' => true,
                    'include_raw_data' => true,
                ],
                'metadata' => [
                    'high_relevance_percentage' => 72.3,
                    'very_relevant_count' => 45,
                    'relevant_count' => 38,
                ],
                'generated_at' => now()->subDay(),
                'expires_at' => now()->addDays(29),
            ],
            [
                'title' => 'Laporan Komprehensif BAN-PT 2024',
                'report_type' => 'ban_pt_standard',
                'session_id' => $session->session_id,
                'file_format' => Report::FORMAT_PDF,
                'status' => Report::STATUS_GENERATING,
                'parameters' => [
                    'graduation_years' => [2022, 2023, 2024],
                    'include_charts' => true,
                    'include_raw_data' => true,
                    'comprehensive_analysis' => true,
                ],
                'metadata' => [
                    'estimated_completion' => now()->addMinutes(15),
                    'progress_percentage' => 65,
                ],
                'generated_at' => null,
                'expires_at' => now()->addDays(30),
            ],
            [
                'title' => 'Analisis Distribusi Geografis Alumni',
                'report_type' => 'geographic_distribution',
                'session_id' => $session->session_id,
                'file_format' => Report::FORMAT_CSV,
                'status' => Report::STATUS_PENDING,
                'parameters' => [
                    'include_maps' => true,
                    'group_by_province' => true,
                ],
                'metadata' => [],
                'generated_at' => null,
                'expires_at' => now()->addDays(30),
            ],
            [
                'title' => 'Laporan Tingkat Respons Survey Alumni',
                'report_type' => 'response_rate',
                'session_id' => $session->session_id,
                'file_format' => Report::FORMAT_EXCEL,
                'status' => Report::STATUS_FAILED,
                'parameters' => [
                    'breakdown_by_program' => true,
                    'breakdown_by_year' => true,
                ],
                'metadata' => [
                    'error' => 'Insufficient data for analysis',
                    'failed_at' => now()->subHours(2),
                ],
                'generated_at' => null,
                'expires_at' => now()->addDays(30),
            ],
        ];

        foreach ($reports as $reportData) {
            Report::create($reportData);
            $this->command->info("Created report: {$reportData['title']}");
        }

        $this->command->info('✅ Reports Database Seeding Completed!');
        
        // Show summary
        $this->showSummary();
    }

    private function showSummary()
    {
        $this->command->info('📊 Reports Summary:');
        $this->command->table(
            ['Status', 'Count', 'Percentage'],
            [
                [
                    'Completed', 
                    Report::where('status', Report::STATUS_COMPLETED)->count(),
                    round(Report::where('status', Report::STATUS_COMPLETED)->count() / Report::count() * 100, 1) . '%'
                ],
                [
                    'Generating', 
                    Report::where('status', Report::STATUS_GENERATING)->count(),
                    round(Report::where('status', Report::STATUS_GENERATING)->count() / Report::count() * 100, 1) . '%'
                ],
                [
                    'Pending', 
                    Report::where('status', Report::STATUS_PENDING)->count(),
                    round(Report::where('status', Report::STATUS_PENDING)->count() / Report::count() * 100, 1) . '%'
                ],
                [
                    'Failed', 
                    Report::where('status', Report::STATUS_FAILED)->count(),
                    round(Report::where('status', Report::STATUS_FAILED)->count() / Report::count() * 100, 1) . '%'
                ],
                [
                    'Total', 
                    Report::count(),
                    '100%'
                ],
            ]
        );

        $this->command->info('📋 Report Types:');
        $reportTypes = Report::select('report_type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('report_type')
            ->get();

        foreach ($reportTypes as $type) {
            $label = Report::REPORT_TYPES[$type->report_type] ?? $type->report_type;
            $this->command->info("  • {$label}: {$type->count}");
        }
    }
}
