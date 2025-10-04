<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Alumni\Models\Alumni;
use Modules\Employment\Models\EmploymentHistory;

class AlumniEmploymentStatsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $totalAlumni = Alumni::count();
        
        // Alumni with employment records
        $employedCount = Alumni::whereHas('employmentHistories', function($query) {
            $query->whereNull('deleted_at');
        })->count();
        
        // Currently employed (is_active = 1 or employment_status = 'employed')
        $currentlyEmployedCount = Alumni::whereHas('employmentHistories', function($query) {
            $query->whereNull('deleted_at')
                  ->where(function($q) {
                      $q->where('is_active', 1)
                        ->orWhere('employment_status', 'employed');
                  });
        })->count();
        
        $employmentRate = $totalAlumni > 0 ? round(($currentlyEmployedCount / $totalAlumni) * 100, 1) : 0;
        $totalEmploymentRecords = EmploymentHistory::count();

        return [
            Stat::make('Employment Rate', $employmentRate . '%')
                ->description(number_format($currentlyEmployedCount) . ' dari ' . number_format($totalAlumni) . ' alumni bekerja')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color($employmentRate >= 70 ? 'success' : ($employmentRate >= 50 ? 'warning' : 'danger')),

            Stat::make('Pernah Bekerja', number_format($employedCount))
                ->description('Alumni dengan riwayat pekerjaan')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('info'),

            Stat::make('Total Riwayat Kerja', number_format($totalEmploymentRecords))
                ->description('Data pekerjaan terdaftar')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),
        ];
    }
}
