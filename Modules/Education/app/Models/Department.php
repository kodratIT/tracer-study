<?php

namespace Modules\Education\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departments';
    
    protected $primaryKey = 'department_id';

    protected $fillable = [
        'department_name',
        'faculty_id',
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
        return 'department_id';
    }

    /**
     * Relationship with faculty
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'faculty_id');
    }

    /**
     * Get campus through faculty
     */
    public function campus()
    {
        return $this->hasOneThrough(
            Campus::class,
            Faculty::class,
            'faculty_id', // Foreign key on faculties table
            'campus_id', // Foreign key on campuses table
            'faculty_id', // Local key on departments table
            'campus_id' // Local key on faculties table
        );
    }

    /**
     * Relationship with programs
     */
    public function programs()
    {
        return $this->hasMany(Program::class, 'department_id', 'department_id');
    }

    /**
     * Get department display name with faculty
     */
    public function getDisplayNameAttribute()
    {
        return $this->department_name . ' - ' . $this->faculty->faculty_name;
    }

    /**
     * Get full hierarchy context
     */
    public function getFullContextAttribute()
    {
        return $this->faculty->campus->campus_name . ' → ' . 
               $this->faculty->faculty_name . ' → ' . 
               $this->department_name;
    }

    /**
     * Get hierarchy breadcrumb
     */
    public function getHierarchyAttribute()
    {
        return [
            'campus' => $this->faculty->campus->campus_name,
            'faculty' => $this->faculty->faculty_name,
            'department' => $this->department_name
        ];
    }

    /**
     * Scope for filtering by faculty
     */
    public function scopeByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    /**
     * Scope for filtering by campus
     */
    public function scopeByCampus($query, $campusId)
    {
        return $query->whereHas('faculty', function($q) use ($campusId) {
            $q->where('campus_id', $campusId);
        });
    }

    /**
     * Scope with full hierarchy
     */
    public function scopeWithHierarchy($query)
    {
        return $query->with(['faculty.campus']);
    }
}
