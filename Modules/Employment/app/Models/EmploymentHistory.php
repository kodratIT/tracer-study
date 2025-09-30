<?php

namespace Modules\Employment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Alumni\Models\Alumni;

class EmploymentHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'employment_id';

    protected $fillable = [
        'alumni_id',
        'employer_id',
        'job_title',
        'job_level',
        'start_date',
        'end_date',
        'salary_range',
        'contract_type',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id', 'alumni_id');
    }
}
