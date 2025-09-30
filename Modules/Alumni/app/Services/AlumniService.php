<?php

namespace Modules\Alumni\Services;

use App\Services\BaseService;
use Modules\Alumni\Repositories\AlumniRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AlumniService extends BaseService
{
    public function __construct(AlumniRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get active alumni
     */
    public function getActiveAlumni(): Collection
    {
        return $this->repository->getActive();
    }

    /**
     * Get employed alumni
     */
    public function getEmployedAlumni(): Collection
    {
        return $this->repository->getEmployed();
    }

    /**
     * Get alumni by graduation year
     */
    public function getAlumniByGraduationYear(int $year): Collection
    {
        return $this->repository->getByGraduationYear($year);
    }

    /**
     * Get alumni by major
     */
    public function getAlumniByMajor(string $major): Collection
    {
        return $this->repository->getByMajor($major);
    }

    /**
     * Search alumni
     */
    public function searchAlumni(string $term): Collection
    {
        return $this->repository->search($term);
    }

    /**
     * Get employment statistics
     */
    public function getEmploymentStatistics(): array
    {
        return $this->repository->getEmploymentStats();
    }

    /**
     * Get graduation year statistics
     */
    public function getGraduationYearStatistics(): Collection
    {
        return $this->repository->getByGraduationYearGrouped();
    }

    /**
     * Update employment status
     */
    public function updateEmploymentStatus(int $id, array $employmentData): Model
    {
        $allowedFields = [
            'current_job',
            'current_company',
            'current_salary',
            'job_category',
            'work_location',
            'is_employed',
            'employment_status',
        ];

        $data = array_intersect_key($employmentData, array_flip($allowedFields));
        
        return $this->update($id, $data);
    }

    /**
     * Prepare data before create
     */
    protected function prepareDataForCreate(array $data): array
    {
        // Handle profile photo upload
        if (isset($data['profile_photo']) && $data['profile_photo'] instanceof UploadedFile) {
            $data['profile_photo'] = $this->handleProfilePhotoUpload($data['profile_photo']);
        }

        // Set default values
        $data['is_active'] = $data['is_active'] ?? true;
        $data['is_employed'] = $data['is_employed'] ?? false;

        // Generate NIM if not provided
        if (empty($data['nim'])) {
            $data['nim'] = $this->generateNIM($data['graduation_year'] ?? date('Y'));
        }

        return $data;
    }

    /**
     * Prepare data before update
     */
    protected function prepareDataForUpdate(array $data): array
    {
        // Handle profile photo upload
        if (isset($data['profile_photo']) && $data['profile_photo'] instanceof UploadedFile) {
            $data['profile_photo'] = $this->handleProfilePhotoUpload($data['profile_photo']);
        }

        return $data;
    }

    /**
     * Hook after create
     */
    protected function afterCreate(Model $record, array $data): void
    {
        // Send welcome email, create audit log, etc.
        // This can be implemented using events or jobs
    }

    /**
     * Hook after update
     */
    protected function afterUpdate(Model $record, array $data): void
    {
        // Log changes, send notifications, etc.
    }

    /**
     * Hook before delete
     */
    protected function beforeDelete(Model $record): void
    {
        // Delete profile photo if exists
        if ($record->profile_photo) {
            Storage::disk('public')->delete($record->profile_photo);
        }
    }

    /**
     * Handle profile photo upload
     */
    private function handleProfilePhotoUpload(UploadedFile $file): string
    {
        $path = $file->store('alumni/profiles', 'public');
        return $path;
    }

    /**
     * Generate NIM
     */
    private function generateNIM(int $graduationYear): string
    {
        $lastTwoDigits = substr($graduationYear, -2);
        $count = $this->repository->where('graduation_year', $graduationYear)->count() + 1;
        $sequence = str_pad($count, 4, '0', STR_PAD_LEFT);
        
        return $lastTwoDigits . $sequence;
    }
}
