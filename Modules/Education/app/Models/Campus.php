<?php

namespace Modules\Education\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'campuses';
    
    protected $primaryKey = 'campus_id';

    protected $fillable = [
        'campus_name',
        'city',
        'province',
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
        return 'campus_id';
    }

    /**
     * Relationship with faculties
     */
    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'campus_id', 'campus_id');
    }

    /**
     * Get departments through faculties
     */
    public function departments()
    {
        return $this->hasManyThrough(
            Department::class,
            Faculty::class,
            'campus_id', // Foreign key on faculties table
            'faculty_id', // Foreign key on departments table
            'campus_id', // Local key on campuses table
            'faculty_id' // Local key on faculties table
        );
    }

    /**
     * Get programs through faculties and departments
     */
    public function programs()
    {
        return $this->hasManyThrough(
            Program::class,
            Department::class,
            'campus_id', // Foreign key on departments table (through faculty)
            'department_id', // Foreign key on programs table
            'campus_id', // Local key on campuses table
            'department_id' // Local key on departments table
        );
    }

    /**
     * Get full location string
     */
    public function getLocationAttribute()
    {
        return $this->city . ', ' . $this->province;
    }

    /**
     * Get campus display name with location
     */
    public function getDisplayNameAttribute()
    {
        return $this->campus_name . ' (' . $this->location . ')';
    }

    /**
     * Scope for filtering by city
     */
    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    /**
     * Scope for filtering by province
     */
    public function scopeByProvince($query, $province)
    {
        return $query->where('province', $province);
    }
}
