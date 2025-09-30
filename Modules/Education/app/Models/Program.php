<?php

namespace Modules\Education\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Alumni\Models\Alumni;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'programs';
    
    protected $primaryKey = 'program_id';

    protected $fillable = [
        'program_name',
        'department_id',
        'accreditation_status',
        'start_year',
        'end_year',
    ];

    protected $casts = [
        'start_year' => 'integer',
        'end_year' => 'integer',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the route key name for Laravel Route Model Binding.
     */
    public function getRouteKeyName(): string
    {
        return 'program_id';
    }

    /**
     * Relationship with department
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    /**
     * Get faculty through department
     */
    public function faculty()
    {
        return $this->hasOneThrough(
            Faculty::class,
            Department::class,
            'department_id', // Foreign key on departments table
            'faculty_id', // Foreign key on faculties table
            'department_id', // Local key on programs table
            'faculty_id' // Local key on departments table
        );
    }

    /**
     * Get campus through department and faculty
     */
    public function campus()
    {
        return $this->hasOneThrough(
            Campus::class,
            Department::class,
            'department_id', // Foreign key on departments table
            'campus_id', // Foreign key on campuses table (through faculty)
            'department_id', // Local key on programs table
            'campus_id' // Local key on departments table (through faculty)
        );
    }

    /**
     * Relationship with education histories (alumni)
     */
    public function educationHistories()
    {
        return $this->hasMany(EducationHistory::class, 'program_id', 'program_id');
    }

    /**
     * Get alumni through education histories
     */
    public function alumni()
    {
        return $this->hasManyThrough(
            Alumni::class,
            EducationHistory::class,
            'program_id', // Foreign key on education_histories table
            'alumni_id', // Foreign key on alumni table
            'program_id', // Local key on programs table
            'alumni_id' // Local key on education_histories table
        );
    }

    /**
     * Get program display name with department
     */
    public function getDisplayNameAttribute()
    {
        return $this->program_name . ' - ' . $this->department->department_name;
    }

    /**
     * Get full hierarchy context
     */
    public function getFullContextAttribute()
    {
        return $this->department->faculty->campus->campus_name . ' → ' . 
               $this->department->faculty->faculty_name . ' → ' . 
               $this->department->department_name . ' → ' . 
               $this->program_name;
    }

    /**
     * Get active years display
     */
    public function getActiveYearsAttribute()
    {
        if ($this->end_year) {
            return $this->start_year . ' - ' . $this->end_year;
        }
        return $this->start_year . ' - Aktif';
    }

    /**
     * Get accreditation badge color
     */
    public function getAccreditationColorAttribute()
    {
        return match($this->accreditation_status) {
            'A', 'Unggul' => 'success',
            'B', 'Baik Sekali' => 'warning', 
            'C', 'Baik' => 'danger',
            default => 'gray'
        };
    }

    /**
     * Check if program is currently active
     */
    public function getIsActiveAttribute()
    {
        return is_null($this->end_year) || $this->end_year >= now()->year;
    }

    /**
     * Scope for filtering by department
     */
    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Scope for filtering by faculty
     */
    public function scopeByFaculty($query, $facultyId)
    {
        return $query->whereHas('department', function($q) use ($facultyId) {
            $q->where('faculty_id', $facultyId);
        });
    }

    /**
     * Scope for filtering by campus
     */
    public function scopeByCampus($query, $campusId)
    {
        return $query->whereHas('department.faculty', function($q) use ($campusId) {
            $q->where('campus_id', $campusId);
        });
    }

    /**
     * Scope for active programs
     */
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('end_year')
              ->orWhere('end_year', '>=', now()->year);
        });
    }

    /**
     * Scope for inactive programs
     */
    public function scopeInactive($query)
    {
        return $query->where('end_year', '<', now()->year);
    }

    /**
     * Scope by accreditation
     */
    public function scopeByAccreditation($query, $status)
    {
        return $query->where('accreditation_status', $status);
    }

    /**
     * Scope with full hierarchy
     */
    public function scopeWithHierarchy($query)
    {
        return $query->with(['department.faculty.campus']);
    }
}
