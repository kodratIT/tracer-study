<?php

namespace Modules\Employment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Alumni\Models\Address;

class Employer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employers';
    
    protected $primaryKey = 'employer_id';

    protected $fillable = [
        'employer_name',
        'industry_type',
        'website',
        'address_id',
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
        return 'employer_id';
    }

    /**
     * Scope for specific industry type
     */
    public function scopeByIndustry($query, $industry)
    {
        return $query->where('industry_type', $industry);
    }

    /**
     * Relationship with address
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }

    /**
     * Relationship with employment histories
     */
    public function employmentHistories()
    {
        return $this->hasMany(EmploymentHistory::class, 'employer_id', 'employer_id');
    }

    /**
     * Get display name with industry
     */
    public function getDisplayNameAttribute()
    {
        return "{$this->employer_name} ({$this->industry_type})";
    }
}
