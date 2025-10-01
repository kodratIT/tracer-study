<?php

namespace Modules\Reports\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Modules\Alumni\Models\Alumni;
use Modules\Employment\Models\EmploymentHistory;
use Modules\Survey\Models\SurveyResponse;
use Illuminate\Support\Facades\DB;

class SummaryStatsExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected array $filters;
    protected ?int $sessionId;

    public function __construct(array $filters = [], ?int $sessionId = null)
    {
        $this->filters = $filters;
        $this->sessionId = $sessionId;
    }

    public function array(): array
    {
        $stats = $this->generateSummaryStatistics();
        
        $data = [];
        
        // Basic Statistics
        $data[] = ['STATISTIK UMUM', ''];
        $data[] = ['Total Alumni', $stats['total_alumni']];
        $data[] = ['Alumni yang Bekerja', $stats['employed_alumni']];
        $data[] = ['Alumni yang Belum Bekerja', $stats['unemployed_alumni']];
        $data[] = ['Tingkat Employment (%)', $stats['employment_rate'] . '%'];
        $data[] = ['', ''];
        
        // Survey Statistics
        if ($this->sessionId) {
            $data[] = ['STATISTIK SURVEY', ''];
            $data[] = ['Total Responden', $stats['total_responses']];
            $data[] = ['Response Completed', $stats['completed_responses']];
            $data[] = ['Response Partial', $stats['partial_responses']];
            $data[] = ['Response Rate (%)', $stats['response_rate'] . '%'];
            $data[] = ['Completion Rate (%)', $stats['completion_rate'] . '%'];
            $data[] = ['', ''];
        }
        
        // Employment by Graduation Year
        $data[] = ['EMPLOYMENT BY GRADUATION YEAR', ''];
        foreach ($stats['employment_by_year'] as $year => $yearStats) {
            $data[] = ["Angkatan $year", $yearStats['employed'] . '/' . $yearStats['total'] . ' (' . $yearStats['rate'] . '%)'];
        }
        $data[] = ['', ''];
        
        // Salary Distribution
        $data[] = ['DISTRIBUSI GAJI', ''];
        foreach ($stats['salary_distribution'] as $range => $count) {
            $data[] = [$range, $count];
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'Kategori',
            'Nilai/Jumlah',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row styling
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D35400'], // Orange
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            
            // Section headers (cells containing all caps text)
            'A:B' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],
        ];
    }

    public function title(): string
    {
        return 'Summary Statistics';
    }

    private function generateSummaryStatistics(): array
    {
        // Basic alumni statistics
        $totalAlumni = Alumni::whereNull('deleted_at')->count();
        
        // Employment statistics
        $employmentStats = DB::table('alumni as a')
            ->leftJoin('employment_histories as eh', function($join) {
                $join->on('a.alumni_id', '=', 'eh.alumni_id')
                     ->whereRaw('eh.start_date = (
                         SELECT MAX(start_date) 
                         FROM employment_histories 
                         WHERE alumni_id = a.alumni_id 
                         AND deleted_at IS NULL
                     )')
                     ->whereNull('eh.deleted_at');
            })
            ->whereNull('a.deleted_at')
            ->select(
                DB::raw('COUNT(a.alumni_id) as total'),
                DB::raw('COUNT(eh.employment_id) as employed')
            )
            ->first();
        
        $employedAlumni = $employmentStats->employed ?? 0;
        $unemployedAlumni = $totalAlumni - $employedAlumni;
        $employmentRate = $totalAlumni > 0 ? round(($employedAlumni / $totalAlumni) * 100, 1) : 0;
        
        // Employment by graduation year
        $employmentByYear = Alumni::select('graduation_year')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('COUNT(eh.employment_id) as employed')
            ->leftJoin('employment_histories as eh', function($join) {
                $join->on('alumni.alumni_id', '=', 'eh.alumni_id')
                     ->whereRaw('eh.start_date = (
                         SELECT MAX(start_date) 
                         FROM employment_histories 
                         WHERE alumni_id = alumni.alumni_id 
                         AND deleted_at IS NULL
                     )')
                     ->whereNull('eh.deleted_at');
            })
            ->whereNull('alumni.deleted_at')
            ->whereNotNull('graduation_year')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year', 'desc')
            ->get()
            ->mapWithKeys(function ($item) {
                $rate = $item->total > 0 ? round(($item->employed / $item->total) * 100, 1) : 0;
                return [
                    $item->graduation_year => [
                        'total' => $item->total,
                        'employed' => $item->employed,
                        'rate' => $rate,
                    ]
                ];
            })
            ->toArray();
        
        // Salary distribution (mock data - will be enhanced with real data)
        $salaryDistribution = [
            '< 3 juta' => 15,
            '3 - 5 juta' => 25,
            '5 - 10 juta' => 30,
            '> 10 juta' => 12,
            'Tidak disebutkan' => 8,
        ];
        
        $result = [
            'total_alumni' => $totalAlumni,
            'employed_alumni' => $employedAlumni,
            'unemployed_alumni' => $unemployedAlumni,
            'employment_rate' => $employmentRate,
            'employment_by_year' => $employmentByYear,
            'salary_distribution' => $salaryDistribution,
        ];
        
        // Add survey statistics if session is specified
        if ($this->sessionId) {
            $surveyStats = SurveyResponse::where('session_id', $this->sessionId)
                ->selectRaw('COUNT(*) as total')
                ->selectRaw('COUNT(CASE WHEN completion_status = "completed" THEN 1 END) as completed')
                ->selectRaw('COUNT(CASE WHEN completion_status = "partial" THEN 1 END) as partial')
                ->first();
            
            $totalResponses = $surveyStats->total ?? 0;
            $completedResponses = $surveyStats->completed ?? 0;
            $partialResponses = $surveyStats->partial ?? 0;
            
            $responseRate = $totalAlumni > 0 ? round(($totalResponses / $totalAlumni) * 100, 1) : 0;
            $completionRate = $totalResponses > 0 ? round(($completedResponses / $totalResponses) * 100, 1) : 0;
            
            $result = array_merge($result, [
                'total_responses' => $totalResponses,
                'completed_responses' => $completedResponses,
                'partial_responses' => $partialResponses,
                'response_rate' => $responseRate,
                'completion_rate' => $completionRate,
            ]);
        }
        
        return $result;
    }
}
