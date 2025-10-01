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
use Modules\Employment\Models\EmploymentHistory;

class EmploymentHistoryExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = EmploymentHistory::query()
            ->with(['alumni'])
            ->whereNull('deleted_at')
            ->orderBy('start_date', 'desc');

        // Apply filters
        if (!empty($this->filters['graduation_years'])) {
            $query->whereHas('alumni', function ($q) {
                $q->whereIn('graduation_year', $this->filters['graduation_years']);
            });
        }

        if (!empty($this->filters['alumni_ids'])) {
            $query->whereIn('alumni_id', $this->filters['alumni_ids']);
        }

        return $query;
    }

    public function map($employment): array
    {
        $alumni = $employment->alumni;
        $duration = $employment->end_date 
            ? $employment->start_date->diffInMonths($employment->end_date) . ' bulan'
            : 'Masih Aktif';

        return [
            $employment->employment_id,
            $alumni?->alumni_id ?? 'N/A',
            $alumni?->name ?? 'N/A',
            $alumni?->graduation_year ?? 'N/A',
            'N/A', // Program name - will be enhanced when relationship exists
            $employment->company_name ?? 'N/A',
            $employment->job_title,
            $employment->employment_status ?? 'N/A',
            $employment->contract_type ?? 'N/A',
            $employment->salary_range ?? 'N/A',
            $employment->start_date?->format('d/m/Y') ?? 'N/A',
            $employment->end_date?->format('d/m/Y') ?? 'Aktif',
            $duration,
            $employment->job_description ?? 'N/A',
            $employment->created_at->format('d/m/Y H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'Employment ID',
            'Alumni ID', 
            'Nama Alumni',
            'Tahun Lulus',
            'Program Studi',
            'Nama Perusahaan',
            'Posisi/Jabatan',
            'Status Employment',
            'Jenis Kontrak',
            'Range Gaji',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Durasi Kerja',
            'Deskripsi Pekerjaan',
            'Tanggal Input',
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
                    'startColor' => ['rgb' => '00B050'], // Green
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            
            // Data rows
            'A:O' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],
        ];
    }

    public function title(): string
    {
        return 'Riwayat Pekerjaan';
    }
}
