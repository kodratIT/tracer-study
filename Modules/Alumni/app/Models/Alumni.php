<?php

namespace Modules\Alumni\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumni extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nim',
        'name',
        'email',
        'phone',
        'graduation_year',
        'major',
        'faculty',
        'gpa',
        'current_job',
        'current_company',
        'current_salary',
        'job_category',
        'work_location',
        'is_employed',
        'employment_status',
        'linkedin_profile',
        'address',
        'profile_photo',
        'is_active',
    ];

    protected $casts = [
        'graduation_year' => 'integer',
        'gpa' => 'decimal:2',
        'current_salary' => 'decimal:2',
        'is_employed' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Scope for active alumni
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for employed alumni
     */
    public function scopeEmployed($query)
    {
        return $query->where('is_employed', true);
    }

    /**
     * Scope for specific graduation year
     */
    public function scopeByGraduationYear($query, $year)
    {
        return $query->where('graduation_year', $year);
    }

    /**
     * Scope for specific major
     */
    public function scopeByMajor($query, $major)
    {
        return $query->where('major', $major);
    }
}
