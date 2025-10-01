<?php

namespace Modules\Reports\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Modules\Survey\Models\SurveyResponse;

class SurveyResponseExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected array $filters;
    protected ?int $sessionId;

    public function __construct(array $filters = [], ?int $sessionId = null)
    {
        $this->filters = $filters;
        $this->sessionId = $sessionId;
    }

    public function query()
    {
        $query = SurveyResponse::query()
            ->with(['alumni'])
            ->whereNull('deleted_at')
            ->orderBy('submitted_at', 'desc');

        // Filter by session if provided
        if ($this->sessionId) {
            $query->where('session_id', $this->sessionId);
        }

        // Apply additional filters
        if (!empty($this->filters['completion_status'])) {
            $query->whereIn('completion_status', $this->filters['completion_status']);
        }

        if (!empty($this->filters['graduation_years'])) {
            $query->whereHas('alumni', function ($q) {
                $q->whereIn('graduation_year', $this->filters['graduation_years']);
            });
        }

        return $query;
    }

    public function map($response): array
    {
        $alumni = $response->alumni;
        
        return [
            $response->response_id,
            $response->session_id,
            $alumni?->alumni_id ?? 'N/A',
            $alumni?->name ?? 'N/A',
            $alumni?->email ?? 'N/A',
            $alumni?->graduation_year ?? 'N/A',
            'N/A', // Program name - will be enhanced when relationship exists
            $this->getCompletionStatusLabel($response->completion_status),
            $response->submitted_at?->format('d/m/Y H:i') ?? 'Belum Submit',
            $response->progress_percentage ?? 0,
            $response->response_data ? 'Ada Data' : 'Kosong',
            $response->created_at->format('d/m/Y H:i'),
            $response->updated_at->format('d/m/Y H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'Response ID',
            'Session ID',
            'Alumni ID',
            'Nama Alumni',
            'Email',
            'Tahun Lulus',
            'Program Studi',
            'Status Pengisian',
            'Tanggal Submit',
            'Progress (%)',
            'Data Response',
            'Tanggal Mulai',
            'Terakhir Update',
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
                    'startColor' => ['rgb' => 'FF6600'], // Orange
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            
            // Data rows
            'A:M' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],
        ];
    }

    public function title(): string
    {
        return 'Survey Responses';
    }

    private function getCompletionStatusLabel(string $status): string
    {
        return match($status) {
            'completed' => 'Selesai',
            'partial' => 'Sebagian',
            'draft' => 'Draft',
            default => 'Tidak Diketahui',
        };
    }
}
