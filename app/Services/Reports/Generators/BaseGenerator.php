<?php

namespace App\Services\Reports\Generators;

use Modules\Reports\Models\Report;
use Modules\Survey\Models\TracerStudySession;
use Modules\Alumni\Models\Alumni;
use Illuminate\Support\Facades\DB;

abstract class BaseGenerator
{
    /**
     * Generate report data
     */
    abstract public function generate(Report $report): array;

    /**
     * Get alumni query with filters
     */
    protected function getAlumniQuery(Report $report)
    {
        $query = Alumni::with(['program.department', 'employmentHistories' => function($q) {
            $q->where('is_active', true);
        }]);

        $params = $report->parameters ?? [];

        // Filter by program
        if (!empty($params['program_ids'])) {
            $query->whereIn('program_id', $params['program_ids']);
        }

        // Filter by graduation year
        if (!empty($params['graduation_year_from'])) {
            $query->where('graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $query->where('graduation_year', '<=', $params['graduation_year_to']);
        }

        return $query;
    }

    /**
     * Get survey responses query
     */
    protected function getSurveyResponsesQuery(Report $report)
    {
        $query = DB::table('survey_responses')
                   ->join('alumni', 'survey_responses.alumni_id', '=', 'alumni.alumni_id');

        if ($report->session_id) {
            $query->where('survey_responses.session_id', $report->session_id);
        }

        $params = $report->parameters ?? [];

        // Filter by program
        if (!empty($params['program_ids'])) {
            $query->whereIn('alumni.program_id', $params['program_ids']);
        }

        // Filter by graduation year
        if (!empty($params['graduation_year_from'])) {
            $query->where('alumni.graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $query->where('alumni.graduation_year', '<=', $params['graduation_year_to']);
        }

        return $query;
    }

    /**
     * Calculate percentage
     */
    protected function percentage($part, $total): float
    {
        if ($total == 0) {
            return 0;
        }

        return round(($part / $total) * 100, 2);
    }

    /**
     * Format number
     */
    protected function formatNumber($number, $decimals = 0): string
    {
        return number_format($number, $decimals, ',', '.');
    }

    /**
     * Get session
     */
    protected function getSession(Report $report): ?TracerStudySession
    {
        if (!$report->session_id) {
            return null;
        }

        return TracerStudySession::find($report->session_id);
    }
}
