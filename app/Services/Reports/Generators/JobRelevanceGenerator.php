<?php

namespace App\Services\Reports\Generators;

use Modules\Reports\Models\Report;
use Illuminate\Support\Facades\DB;

class JobRelevanceGenerator extends BaseGenerator
{
    public function generate(Report $report): array
    {
        $session = $this->getSession($report);
        
        return [
            'title' => $report->title,
            'session' => $session,
            'generated_at' => now()->format('d F Y, H:i'),
            'summary' => $this->getSummary($report),
            'by_program' => $this->getByProgram($report),
            'program_industry_matrix' => $this->getProgramIndustryMatrix($report),
            'details' => $this->getDetails($report),
        ];
    }

    /**
     * Get overall summary
     * 
     * Note: Job relevance is typically measured from survey responses
     * For now, we'll estimate based on program-industry alignment
     */
    protected function getSummary(Report $report): array
    {
        $employmentQuery = DB::table('employment_histories')
            ->join('alumni', 'employment_histories.alumni_id', '=', 'alumni.alumni_id')
            ->join('programs', 'alumni.program_id', '=', 'programs.program_id')
            ->leftJoin('employers', 'employment_histories.employer_id', '=', 'employers.employer_id')
            ->where('employment_histories.is_active', true)
            ->where('employment_histories.employment_status', 'employed');

        $params = $report->parameters ?? [];
        
        if (!empty($params['program_ids'])) {
            $employmentQuery->whereIn('alumni.program_id', $params['program_ids']);
        }

        if (!empty($params['graduation_year_from'])) {
            $employmentQuery->where('alumni.graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $employmentQuery->where('alumni.graduation_year', '<=', $params['graduation_year_to']);
        }

        $totalEmployed = $employmentQuery->count();
        
        // Estimate relevance based on program-industry keywords matching
        $relevant = (clone $employmentQuery)->where(function($q) {
            $q->whereRaw("LOWER(programs.program_name) LIKE '%teknik%' AND LOWER(employers.industry_type) LIKE '%tech%'")
              ->orWhereRaw("LOWER(programs.program_name) LIKE '%komputer%' AND LOWER(employers.industry_type) LIKE '%tech%'")
              ->orWhereRaw("LOWER(programs.program_name) LIKE '%informatika%' AND LOWER(employers.industry_type) LIKE '%tech%'")
              ->orWhereRaw("LOWER(programs.program_name) LIKE '%ekonomi%' AND LOWER(employers.industry_type) LIKE '%finance%'")
              ->orWhereRaw("LOWER(programs.program_name) LIKE '%akuntansi%' AND LOWER(employers.industry_type) LIKE '%finance%'")
              ->orWhereRaw("LOWER(programs.program_name) LIKE '%pendidikan%' AND LOWER(employers.industry_type) LIKE '%education%'")
              ->orWhereRaw("LOWER(programs.program_name) LIKE '%kesehatan%' AND LOWER(employers.industry_type) LIKE '%health%'");
        })->count();

        return [
            'total_employed' => $totalEmployed,
            'relevant' => $relevant,
            'not_relevant' => $totalEmployed - $relevant,
            'relevance_rate' => $this->percentage($relevant, $totalEmployed),
            'note' => 'Relevansi diestimasi berdasarkan kesesuaian program studi dengan jenis industri. Untuk hasil akurat, gunakan data dari survey responses.',
        ];
    }

    /**
     * Get job relevance by program
     */
    protected function getByProgram(Report $report): array
    {
        $query = DB::table('employment_histories')
            ->join('alumni', 'employment_histories.alumni_id', '=', 'alumni.alumni_id')
            ->join('programs', 'alumni.program_id', '=', 'programs.program_id')
            ->leftJoin('employers', 'employment_histories.employer_id', '=', 'employers.employer_id')
            ->where('employment_histories.is_active', true)
            ->where('employment_histories.employment_status', 'employed')
            ->select(
                'programs.program_id',
                'programs.program_name',
                DB::raw('COUNT(*) as total_employed')
            )
            ->groupBy('programs.program_id', 'programs.program_name');

        $params = $report->parameters ?? [];
        
        if (!empty($params['program_ids'])) {
            $query->whereIn('alumni.program_id', $params['program_ids']);
        }

        if (!empty($params['graduation_year_from'])) {
            $query->where('alumni.graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $query->where('alumni.graduation_year', '<=', $params['graduation_year_to']);
        }

        $results = $query->get();

        return $results->map(function($item) use ($report) {
            // Get top industries for this program
            $industries = $this->getTopIndustriesForProgram($report, $item->program_id);
            
            return [
                'program_id' => $item->program_id,
                'program_name' => $item->program_name,
                'total_employed' => $item->total_employed,
                'top_industries' => $industries,
            ];
        })->toArray();
    }

    /**
     * Get top industries for a program
     */
    protected function getTopIndustriesForProgram(Report $report, $programId): array
    {
        $query = DB::table('employment_histories')
            ->join('alumni', 'employment_histories.alumni_id', '=', 'alumni.alumni_id')
            ->join('employers', 'employment_histories.employer_id', '=', 'employers.employer_id')
            ->where('employment_histories.is_active', true)
            ->where('employment_histories.employment_status', 'employed')
            ->where('alumni.program_id', $programId)
            ->select(
                'employers.industry_type',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('employers.industry_type')
            ->orderByDesc('total')
            ->limit(5);

        $params = $report->parameters ?? [];
        
        if (!empty($params['graduation_year_from'])) {
            $query->where('alumni.graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $query->where('alumni.graduation_year', '<=', $params['graduation_year_to']);
        }

        $results = $query->get();
        $totalInProgram = $results->sum('total');

        return $results->map(function($item) use ($totalInProgram) {
            return [
                'industry_type' => $item->industry_type ?? 'Tidak Diketahui',
                'count' => $item->total,
                'percentage' => $this->percentage($item->total, $totalInProgram),
            ];
        })->toArray();
    }

    /**
     * Get program-industry matrix
     * Shows which programs work in which industries
     */
    protected function getProgramIndustryMatrix(Report $report): array
    {
        $query = DB::table('employment_histories')
            ->join('alumni', 'employment_histories.alumni_id', '=', 'alumni.alumni_id')
            ->join('programs', 'alumni.program_id', '=', 'programs.program_id')
            ->leftJoin('employers', 'employment_histories.employer_id', '=', 'employers.employer_id')
            ->where('employment_histories.is_active', true)
            ->where('employment_histories.employment_status', 'employed')
            ->select(
                'programs.program_name',
                'employers.industry_type',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('programs.program_name', 'employers.industry_type');

        $params = $report->parameters ?? [];
        
        if (!empty($params['program_ids'])) {
            $query->whereIn('alumni.program_id', $params['program_ids']);
        }

        if (!empty($params['graduation_year_from'])) {
            $query->where('alumni.graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $query->where('alumni.graduation_year', '<=', $params['graduation_year_to']);
        }

        $results = $query->get();

        // Group by program
        $matrix = [];
        foreach ($results as $item) {
            $programName = $item->program_name;
            $industryType = $item->industry_type ?? 'Tidak Diketahui';
            
            if (!isset($matrix[$programName])) {
                $matrix[$programName] = [];
            }
            
            $matrix[$programName][$industryType] = $item->count;
        }

        return $matrix;
    }

    /**
     * Get detailed list
     */
    protected function getDetails(Report $report): array
    {
        $query = DB::table('employment_histories')
            ->join('alumni', 'employment_histories.alumni_id', '=', 'alumni.alumni_id')
            ->join('programs', 'alumni.program_id', '=', 'programs.program_id')
            ->leftJoin('employers', 'employment_histories.employer_id', '=', 'employers.employer_id')
            ->where('employment_histories.is_active', true)
            ->where('employment_histories.employment_status', 'employed')
            ->select(
                'alumni.student_id',
                'alumni.name',
                'programs.program_name',
                'alumni.graduation_year',
                'employment_histories.job_title',
                'employers.employer_name',
                'employers.industry_type',
                'employment_histories.job_level'
            )
            ->orderBy('programs.program_name')
            ->orderBy('alumni.name');

        $params = $report->parameters ?? [];
        
        if (!empty($params['program_ids'])) {
            $query->whereIn('alumni.program_id', $params['program_ids']);
        }

        if (!empty($params['graduation_year_from'])) {
            $query->where('alumni.graduation_year', '>=', $params['graduation_year_from']);
        }

        if (!empty($params['graduation_year_to'])) {
            $query->where('alumni.graduation_year', '<=', $params['graduation_year_to']);
        }

        return $query->get()->map(function($item) {
            return [
                'student_id' => $item->student_id,
                'name' => $item->name,
                'program_name' => $item->program_name,
                'graduation_year' => $item->graduation_year,
                'job_title' => $item->job_title,
                'employer_name' => $item->employer_name ?? '-',
                'industry_type' => $item->industry_type ?? 'Tidak Diketahui',
                'job_level' => $item->job_level,
            ];
        })->toArray();
    }
}
