<?php

namespace Modules\Survey\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Alumni\Models\Alumni;

class TracerStudySession extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tracer_study_sessions';
    
    protected $primaryKey = 'session_id';

    protected $fillable = [
        'year',
        'start_date',
        'end_date',
        'description',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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
        return 'session_id';
    }

    /**
     * Scope for active sessions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for current sessions (ongoing or upcoming)
     */
    public function scopeCurrent($query)
    {
        return $query->where('end_date', '>=', now()->toDateString());
    }

    /**
     * Scope for sessions by year
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Check if session is currently ongoing
     */
    public function getIsOngoingAttribute()
    {
        $now = now()->toDateString();
        return $this->start_date <= $now && $this->end_date >= $now;
    }

    /**
     * Check if session is upcoming
     */
    public function getIsUpcomingAttribute()
    {
        return $this->start_date > now()->toDateString();
    }

    /**
     * Check if session has ended
     */
    public function getIsExpiredAttribute()
    {
        return $this->end_date < now()->toDateString();
    }

    /**
     * Get session status
     */
    public function getStatusAttribute()
    {
        if ($this->is_upcoming) {
            return 'upcoming';
        } elseif ($this->is_ongoing) {
            return 'ongoing';
        } elseif ($this->is_expired) {
            return 'expired';
        }
        return 'unknown';
    }

    /**
     * Get session duration in days
     */
    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Get display name for session
     */
    public function getDisplayNameAttribute()
    {
        return "Tracer Study {$this->year} ({$this->start_date->format('M d')} - {$this->end_date->format('M d')})";
    }

    /**
     * Relationship with survey responses
     */
    public function surveyResponses()
    {
        return $this->hasMany(SurveyResponse::class, 'session_id', 'session_id');
    }

    /**
     * Get alumni who have responded to this session
     */
    public function respondingAlumni()
    {
        return $this->belongsToMany(Alumni::class, 'survey_responses', 'session_id', 'alumni_id')
                    ->withPivot(['response_id', 'submitted_at', 'completion_status'])
                    ->withTimestamps();
    }

    /**
     * Get completed responses count
     */
    public function getCompletedResponsesCountAttribute()
    {
        return $this->surveyResponses()->where('completion_status', 'completed')->count();
    }

    /**
     * Get partial responses count
     */
    public function getPartialResponsesCountAttribute()
    {
        return $this->surveyResponses()->where('completion_status', 'partial')->count();
    }

    /**
     * Get draft responses count
     */
    public function getDraftResponsesCountAttribute()
    {
        return $this->surveyResponses()->where('completion_status', 'draft')->count();
    }

    /**
     * Get total responses count
     */
    public function getTotalResponsesCountAttribute()
    {
        return $this->surveyResponses()->count();
    }

    /**
     * Calculate response rate percentage
     */
    public function getResponseRateAttribute()
    {
        $totalAlumni = Alumni::count(); // You might want to filter by graduation year or specific criteria
        $totalResponses = $this->total_responses_count;
        
        return $totalAlumni > 0 ? round(($totalResponses / $totalAlumni) * 100, 2) : 0;
    }
}
