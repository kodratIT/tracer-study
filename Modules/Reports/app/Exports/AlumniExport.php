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
use Modules\Alumni\Models\Alumni;
use Illuminate\Database\Eloquent\Builder;

class AlumniExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Alumni::query()
            ->with(['employmentHistories' => function ($q) {
                $q->orderBy('start_date', 'desc')->limit(1);
            }])
            ->whereNull('deleted_at')
            ->orderBy('graduation_year', 'desc')
            ->orderBy('name');

        // Apply filters
        if (!empty($this->filters['graduation_years'])) {
            $query->whereIn('graduation_year', $this->filters['graduation_years']);
        }

        if (!empty($this->filters['program_ids'])) {
            $query->whereIn('program_id', $this->filters['program_ids']);
        }

        return $query;
    }

    public function map($alumni): array
    {
        $latestEmployment = $alumni->employmentHistories->first();

        return [
            $alumni->alumni_id,
            $alumni->student_id,
            $alumni->name,
            $alumni->email,
            $alumni->phone,
            $alumni->gender,
            $alumni->graduation_year,
            $alumni->gpa,
            'N/A', // Program name - will be enhanced when relationship exists
            $latestEmployment ? 'Bekerja' : 'Belum Bekerja',
            $latestEmployment?->job_title ?? 'N/A',
            $latestEmployment?->company_name ?? 'N/A',
            $latestEmployment?->salary_range ?? 'N/A',
            $latestEmployment?->start_date?->format('d/m/Y') ?? 'N/A',
            $alumni->created_at->format('d/m/Y H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'Alumni ID',
            'Student ID',
            'Nama Lengkap',
            'Email',
            'No. Telepon',
            'Jenis Kelamin',
            'Tahun Lulus',
            'IPK',
            'Program Studi',
            'Status Pekerjaan',
            'Posisi/Jabatan',
            'Nama Perusahaan',
            'Range Gaji',
            'Tanggal Mulai Kerja',
            'Tanggal Registrasi',
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
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            
            // Auto-fit columns
            'A:O' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Alumni';
    }
}
