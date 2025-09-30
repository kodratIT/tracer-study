<?php

namespace Modules\Alumni\Repositories;

use App\Repositories\BaseRepository;
use Modules\Alumni\Models\Alumni;
use Illuminate\Database\Eloquent\Collection;

class AlumniRepository extends BaseRepository
{
    public function __construct(Alumni $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active alumni
     */
    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }

    /**
     * Get employed alumni
     */
    public function getEmployed(): Collection
    {
        return $this->model->employed()->get();
    }

    /**
     * Get alumni by graduation year
     */
    public function getByGraduationYear(int $year): Collection
    {
        return $this->model->byGraduationYear($year)->get();
    }

    /**
     * Get alumni by major
     */
    public function getByMajor(string $major): Collection
    {
        return $this->model->byMajor($major)->get();
    }

    /**
     * Search alumni by name or email
     */
    public function search(string $term): Collection
    {
        return $this->model->where('name', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->orWhere('nim', 'LIKE', "%{$term}%")
            ->get();
    }

    /**
     * Get employment statistics
     */
    public function getEmploymentStats(): array
    {
        $total = $this->model->count();
        $employed = $this->model->employed()->count();
        $unemployed = $total - $employed;

        return [
            'total' => $total,
            'employed' => $employed,
            'unemployed' => $unemployed,
            'employment_rate' => $total > 0 ? round(($employed / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Get alumni grouped by graduation year
     */
    public function getByGraduationYearGrouped(): Collection
    {
        return $this->model->selectRaw('graduation_year, COUNT(*) as count')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year', 'desc')
            ->get();
    }
}
