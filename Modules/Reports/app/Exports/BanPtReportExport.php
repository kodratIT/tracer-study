<?php

namespace Modules\Reports\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Modules\Reports\Models\Report;

class BanPtReportExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $report;
    protected $data;

    public function __construct(Report $report, array $data)
    {
        $this->report = $report;
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        if (empty($this->data)) {
            return ['No Data Available'];
        }

        // Return headings based on report type
        switch ($this->report->report_type) {
            case 'employment_statistics':
                return [
                    'Alumni ID',
                    'Nama',
                    'Program Studi',
                    'Tahun Lulus',
                    'Status Kerja',
                    'Nama Perusahaan',
                    'Posisi',
                    'Gaji',
                    'Masa Tunggu (Bulan)'
                ];

            case 'waiting_period':
                return [
                    'Program Studi',
                    'Tahun Lulus',
                    'Rata-rata Masa Tunggu (Bulan)',
                    'Median Masa Tunggu',
                    'Total Alumni',
                    'Yang Sudah Bekerja'
                ];

            case 'job_relevance':
                return [
                    'Alumni ID',
                    'Nama',
                    'Program Studi',
                    'Bidang Pekerjaan',
                    'Tingkat Relevansi',
                    'Kesesuaian Kompetensi',
                    'Kepuasan Kerja'
                ];

            default:
                return array_keys($this->data[0] ?? []);
        }
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Set auto-width for all columns
            'A:Z' => ['alignment' => ['horizontal' => 'left']],
        ];
    }

    public function title(): string
    {
        return substr($this->report->title, 0, 31); // Excel sheet title limit
    }
}
