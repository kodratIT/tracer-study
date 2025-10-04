<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected string $view = 'filament.widgets.quick-actions-widget';

    public function getQuickActions(): array
    {
        return [
            [
                'label' => 'Kelola Alumni',
                'icon' => 'heroicon-o-academic-cap',
                'url' => route('filament.admin.resources.alumni.index'),
                'color' => 'primary',
                'description' => 'Lihat dan kelola data alumni',
            ],
            [
                'label' => 'Survey Responses',
                'icon' => 'heroicon-o-clipboard-document-list',
                'url' => route('filament.admin.resources.survey-responses.index'),
                'color' => 'success',
                'description' => 'Monitor respons survei',
            ],
            [
                'label' => 'Buat Laporan',
                'icon' => 'heroicon-o-document-plus',
                'url' => route('filament.admin.resources.reports.create'),
                'color' => 'warning',
                'description' => 'Generate laporan baru',
            ],
            [
                'label' => 'Lihat Laporan',
                'icon' => 'heroicon-o-chart-bar',
                'url' => route('filament.admin.resources.reports.index'),
                'color' => 'info',
                'description' => 'Akses semua laporan',
            ],
        ];
    }
}
