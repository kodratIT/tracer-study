<?php

namespace Modules\Alumni\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Employment\Models\EmploymentHistory;
use Modules\Education\Models\EducationHistory;

class Alumni extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alumni';
    
    protected $primaryKey = 'alumni_id';

    protected $fillable = [
        'student_id',
        'name',
        'email',
        'phone',
        'gender',
        'birth_date',
        'graduation_year',
        'gpa',
        'program_id',
        'address_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'graduation_year' => 'integer',
        'gpa' => 'decimal:2',
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
        return 'alumni_id';
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
     * Relationship with address
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }

    /**
     * Relationship with contact methods
     */
    public function contactMethods()
    {
        return $this->hasMany(ContactMethod::class, 'alumni_id', 'alumni_id');
    }

    /**
     * Relationship with employment histories
     */
    public function employmentHistories()
    {
        return $this->hasMany(EmploymentHistory::class, 'alumni_id', 'alumni_id');
    }

    /**
     * Relationship with education histories
     */
    public function educationHistories()
    {
        return $this->hasMany(EducationHistory::class, 'alumni_id', 'alumni_id');
    }

    /**
     * Get primary contact method by type
     */
    public function getPrimaryContact($type)
    {
        return $this->contactMethods()->byType($type)->primary()->first();
    }

    /**
     * Get full name with student ID
     */
    public function getDisplayNameAttribute()
    {
        return "{$this->name} ({$this->student_id})";
    }
}
