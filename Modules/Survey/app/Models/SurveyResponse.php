<?php

namespace Modules\Survey\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Alumni\Models\Alumni;

class SurveyResponse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'survey_responses';
    
    protected $primaryKey = 'response_id';

    protected $fillable = [
        'session_id',
        'alumni_id',
        'submitted_at',
        'completion_status',
        'metadata',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'metadata' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'submitted_at',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'response_id';
    }

    /**
     * Scope for completed responses
     */
    public function scopeCompleted($query)
    {
        return $query->where('completion_status', 'completed');
    }

    /**
     * Scope for partial responses
     */
    public function scopePartial($query)
    {
        return $query->where('completion_status', 'partial');
    }

    /**
     * Scope for draft responses
     */
    public function scopeDraft($query)
    {
        return $query->where('completion_status', 'draft');
    }

    /**
     * Scope for submitted responses
     */
    public function scopeSubmitted($query)
    {
        return $query->whereNotNull('submitted_at');
    }

    /**
     * Check if response is completed
     */
    public function getIsCompletedAttribute()
    {
        return $this->completion_status === 'completed';
    }

    /**
     * Check if response is partial
     */
    public function getIsPartialAttribute()
    {
        return $this->completion_status === 'partial';
    }

    /**
     * Check if response is draft
     */
    public function getIsDraftAttribute()
    {
        return $this->completion_status === 'draft';
    }

    /**
     * Get completion percentage (this would need to be calculated based on actual answers)
     */
    public function getCompletionPercentageAttribute()
    {
        // This is a placeholder - in real implementation, you'd calculate based on answered questions
        return match($this->completion_status) {
            'completed' => 100,
            'partial' => 50, // This should be calculated from actual question answers
            'draft' => 10,
            default => 0,
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->completion_status) {
            'completed' => 'success',
            'partial' => 'warning', 
            'draft' => 'secondary',
            default => 'gray',
        };
    }

    /**
     * Relationship with tracer study session
     */
    public function session()
    {
        return $this->belongsTo(TracerStudySession::class, 'session_id', 'session_id');
    }

    /**
     * Relationship with alumni
     */
    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id', 'alumni_id');
    }

    /**
     * Get display name for response
     */
    public function getDisplayNameAttribute()
    {
        return $this->alumni?->name . ' - ' . $this->session?->display_name;
    }
}
