<?php

namespace App\Services\Reports\Exporters;

use Modules\Reports\Models\Report;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ExcelExporter
{
    /**
     * Export report to Excel
     */
    public function export(Report $report, array $data): string
    {
        // Generate filename
        $filename = $this->generateFilename($report);
        
        // Create export class based on report type
        $export = $this->getExportClass($report, $data);
        
        // Save to storage
        $path = "reports/excel/{$filename}";
        Excel::store($export, $path, 'local');
        
        return $path;
    }

    /**
     * Generate unique filename
     */
    protected function generateFilename(Report $report): string
    {
        $slug = Str::slug($report->title);
        $timestamp = now()->format('Ymd_His');
        
        return "{$slug}_{$timestamp}.xlsx";
    }

    /**
     * Get export class instance based on report type
     */
    protected function getExportClass(Report $report, array $data)
    {
        switch ($report->report_type) {
            case 'response_rate':
                return new ResponseRateExport($data);
            case 'employment_statistics':
                return new EmploymentStatisticsExport($data);
            case 'waiting_period':
                return new WaitingPeriodExport($data);
            case 'job_relevance':
                return new JobRelevanceExport($data);
            default:
                return new GenericReportExport($data);
        }
    }
}

/**
 * Generic Report Export
 */
class GenericReportExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        // Convert data to array format
        if (isset($this->data['details']) && is_array($this->data['details'])) {
            return $this->data['details'];
        }
        
        return [];
    }

    public function headings(): array
    {
        // Get headings from first row
        if (!empty($this->data['details'])) {
            $firstRow = $this->data['details'][0];
            return array_keys($firstRow);
        }
        
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E2E8F0']]],
        ];
    }

    public function title(): string
    {
        return 'Report Data';
    }
}

/**
 * Response Rate Export with multiple sheets
 */
class ResponseRateExport implements WithMultipleSheets
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new ResponseRateSummarySheet($this->data),
            new ResponseRateByProgramSheet($this->data),
            new ResponseRateDetailsSheet($this->data),
        ];
    }
}

class ResponseRateSummarySheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $summary = $this->data['summary'] ?? [];
        
        return [
            ['Total Alumni', $summary['total_alumni'] ?? 0],
            ['Total Responded', $summary['total_responded'] ?? 0],
            ['Total Completed', $summary['total_completed'] ?? 0],
            ['Total Partial', $summary['total_partial'] ?? 0],
            ['Total Draft', $summary['total_draft'] ?? 0],
            ['Total Not Started', $summary['total_not_started'] ?? 0],
            ['Response Rate (%)', $summary['response_rate'] ?? 0],
            ['Completion Rate (%)', $summary['completion_rate'] ?? 0],
        ];
    }

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F46E5']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'Summary';
    }
}

class ResponseRateByProgramSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $byProgram = $this->data['by_program'] ?? [];
        
        return array_map(function($item) {
            return [
                $item['program_name'] ?? '',
                $item['department_name'] ?? '',
                $item['total_alumni'] ?? 0,
                $item['total_responses'] ?? 0,
                $item['total_completed'] ?? 0,
                $item['response_rate'] ?? 0,
                $item['completion_rate'] ?? 0,
            ];
        }, $byProgram);
    }

    public function headings(): array
    {
        return ['Program Studi', 'Department', 'Total Alumni', 'Total Responses', 'Total Completed', 'Response Rate (%)', 'Completion Rate (%)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F46E5']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'By Program';
    }
}

class ResponseRateDetailsSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $details = $this->data['details'] ?? [];
        
        return array_map(function($item) {
            return [
                $item['student_id'] ?? '',
                $item['name'] ?? '',
                $item['program_name'] ?? '',
                $item['graduation_year'] ?? '',
                $item['email'] ?? '',
                $item['phone'] ?? '',
                $item['status_label'] ?? '',
                $item['submitted_at'] ?? '',
            ];
        }, $details);
    }

    public function headings(): array
    {
        return ['NIM', 'Name', 'Program', 'Graduation Year', 'Email', 'Phone', 'Status', 'Submitted At'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F46E5']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'Details';
    }
}

/**
 * Employment Statistics Export
 */
class EmploymentStatisticsExport implements WithMultipleSheets
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new EmploymentSummarySheet($this->data),
            new EmploymentByProgramSheet($this->data),
            new EmploymentByStatusSheet($this->data),
            new EmploymentByIndustrySheet($this->data),
        ];
    }
}

class EmploymentSummarySheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $summary = $this->data['summary'] ?? [];
        
        return [
            ['Total Alumni', $summary['total_alumni'] ?? 0],
            ['Employed', $summary['employed'] ?? 0],
            ['Entrepreneur', $summary['entrepreneur'] ?? 0],
            ['Studying', $summary['studying'] ?? 0],
            ['Unemployed', $summary['unemployed'] ?? 0],
            ['No Data', $summary['no_data'] ?? 0],
            ['Employment Rate (%)', $summary['employment_rate'] ?? 0],
        ];
    }

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '10B981']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'Summary';
    }
}

class EmploymentByProgramSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $byProgram = $this->data['by_program'] ?? [];
        
        return array_map(function($item) {
            return [
                $item['program_name'] ?? '',
                $item['total_alumni'] ?? 0,
                $item['employed'] ?? 0,
                $item['entrepreneur'] ?? 0,
                $item['studying'] ?? 0,
                $item['unemployed'] ?? 0,
                $item['no_data'] ?? 0,
                $item['employment_rate'] ?? 0,
            ];
        }, $byProgram);
    }

    public function headings(): array
    {
        return ['Program', 'Total', 'Employed', 'Entrepreneur', 'Studying', 'Unemployed', 'No Data', 'Employment Rate (%)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '10B981']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'By Program';
    }
}

class EmploymentByStatusSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $byStatus = $this->data['by_status'] ?? [];
        
        return array_map(function($item) {
            return [
                $item['label'] ?? '',
                $item['count'] ?? 0,
                $item['percentage'] ?? 0,
            ];
        }, $byStatus);
    }

    public function headings(): array
    {
        return ['Status', 'Count', 'Percentage (%)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '10B981']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'By Status';
    }
}

class EmploymentByIndustrySheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $byIndustry = $this->data['by_industry'] ?? [];
        
        return array_map(function($item) {
            return [
                $item['industry_type'] ?? '',
                $item['count'] ?? 0,
                $item['percentage'] ?? 0,
            ];
        }, $byIndustry);
    }

    public function headings(): array
    {
        return ['Industry', 'Count', 'Percentage (%)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '10B981']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'By Industry';
    }
}

/**
 * Waiting Period Export
 */
class WaitingPeriodExport implements WithMultipleSheets
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new WaitingPeriodSummarySheet($this->data),
            new WaitingPeriodByProgramSheet($this->data),
            new WaitingPeriodDetailsSheet($this->data),
        ];
    }
}

class WaitingPeriodSummarySheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $summary = $this->data['summary'] ?? [];
        
        return [
            ['Total Alumni', $summary['total_alumni'] ?? 0],
            ['With Data', $summary['with_data'] ?? 0],
            ['Average (months)', $summary['average_months'] ?? 0],
            ['Median (months)', $summary['median_months'] ?? 0],
            ['Min (months)', $summary['min_months'] ?? 0],
            ['Max (months)', $summary['max_months'] ?? 0],
        ];
    }

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'F59E0B']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'Summary';
    }
}

class WaitingPeriodByProgramSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $byProgram = $this->data['by_program'] ?? [];
        
        return array_map(function($item) {
            return [
                $item['program_name'] ?? '',
                $item['total_alumni'] ?? 0,
                $item['with_data'] ?? 0,
                $item['average_months'] ?? 0,
                $item['median_months'] ?? 0,
                $item['less_than_3_months'] ?? 0,
            ];
        }, $byProgram);
    }

    public function headings(): array
    {
        return ['Program', 'Total Alumni', 'With Data', 'Avg (months)', 'Median (months)', '< 3 Months'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'F59E0B']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'By Program';
    }
}

class WaitingPeriodDetailsSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $details = $this->data['details'] ?? [];
        
        return array_map(function($item) {
            return [
                $item['student_id'] ?? '',
                $item['name'] ?? '',
                $item['program_name'] ?? '',
                $item['graduation_year'] ?? '',
                $item['graduation_date'] ?? '',
                $item['employment_date'] ?? '',
                $item['waiting_months'] ?? '',
                $item['waiting_label'] ?? '',
            ];
        }, $details);
    }

    public function headings(): array
    {
        return ['NIM', 'Name', 'Program', 'Grad Year', 'Grad Date', 'Employment Date', 'Waiting (months)', 'Category'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'F59E0B']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'Details';
    }
}

/**
 * Job Relevance Export
 */
class JobRelevanceExport implements WithMultipleSheets
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new JobRelevanceSummarySheet($this->data),
            new JobRelevanceByProgramSheet($this->data),
            new JobRelevanceDetailsSheet($this->data),
        ];
    }
}

class JobRelevanceSummarySheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $summary = $this->data['summary'] ?? [];
        
        return [
            ['Total Employed', $summary['total_employed'] ?? 0],
            ['Relevant', $summary['relevant'] ?? 0],
            ['Not Relevant', $summary['not_relevant'] ?? 0],
            ['Relevance Rate (%)', $summary['relevance_rate'] ?? 0],
            ['Note', $summary['note'] ?? ''],
        ];
    }

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '3B82F6']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'Summary';
    }
}

class JobRelevanceByProgramSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $byProgram = $this->data['by_program'] ?? [];
        
        $rows = [];
        foreach ($byProgram as $program) {
            $programName = $program['program_name'] ?? '';
            $totalEmployed = $program['total_employed'] ?? 0;
            
            $rows[] = [$programName, $totalEmployed, ''];
            
            $topIndustries = $program['top_industries'] ?? [];
            foreach ($topIndustries as $industry) {
                $rows[] = [
                    '',
                    '',
                    $industry['industry_type'] ?? '',
                    $industry['count'] ?? 0,
                    $industry['percentage'] ?? 0,
                ];
            }
            
            $rows[] = ['', '', '', '', '']; // Separator
        }
        
        return $rows;
    }

    public function headings(): array
    {
        return ['Program', 'Total Employed', 'Industry', 'Count', 'Percentage (%)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '3B82F6']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'By Program';
    }
}

class JobRelevanceDetailsSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $details = $this->data['details'] ?? [];
        
        return array_map(function($item) {
            return [
                $item['student_id'] ?? '',
                $item['name'] ?? '',
                $item['program_name'] ?? '',
                $item['job_title'] ?? '',
                $item['employer_name'] ?? '',
                $item['industry_type'] ?? '',
                $item['job_level'] ?? '',
            ];
        }, $details);
    }

    public function headings(): array
    {
        return ['NIM', 'Name', 'Program', 'Job Title', 'Employer', 'Industry', 'Job Level'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '3B82F6']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'Details';
    }
}
