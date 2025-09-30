<?php

namespace Modules\Education\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Alumni\Models\Alumni;

class EducationHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'education_history_id';

    protected $fillable = [
        'alumni_id',
        'program_id',
        'start_date',
        'end_date',
        'gpa',
        'thesis_title',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'gpa' => 'decimal:2',
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
