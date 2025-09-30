<?php

namespace Modules\Education\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faculties';
    
    protected $primaryKey = 'faculty_id';

    protected $fillable = [
        'faculty_name',
        'campus_id',
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
        return 'faculty_id';
    }

    /**
     * Relationship with campus
     */
    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id', 'campus_id');
    }

    /**
     * Relationship with departments
     */
    public function departments()
    {
        return $this->hasMany(Department::class, 'faculty_id', 'faculty_id');
    }

    /**
     * Get programs through departments
     */
    public function programs()
    {
        return $this->hasManyThrough(
            Program::class,
            Department::class,
            'faculty_id', // Foreign key on departments table
            'department_id', // Foreign key on programs table
            'faculty_id', // Local key on faculties table
            'department_id' // Local key on departments table
        );
    }

    /**
     * Get faculty display name with campus
     */
    public function getDisplayNameAttribute()
    {
        return $this->faculty_name . ' - ' . $this->campus->campus_name;
    }

    /**
     * Get full context (campus + faculty)
     */
    public function getFullContextAttribute()
    {
        return $this->campus->campus_name . ' → ' . $this->faculty_name;
    }

    /**
     * Scope for filtering by campus
     */
    public function scopeByCampus($query, $campusId)
    {
        return $query->where('campus_id', $campusId);
    }

    /**
     * Scope with campus information
     */
    public function scopeWithCampus($query)
    {
        return $query->with('campus');
    }
}
