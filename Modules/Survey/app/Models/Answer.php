<?php

namespace Modules\Survey\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'answers';
    protected $primaryKey = 'answer_id';

    protected $fillable = [
        'response_id',
        'question_id',
        'option_id',
        'answer_text',
        'rating_value',
        'additional_data',
    ];

    protected $casts = [
        'additional_data' => 'array',
        'rating_value' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationship with survey response
     */
    public function response(): BelongsTo
    {
        return $this->belongsTo(SurveyResponse::class, 'response_id', 'response_id');
    }

    /**
     * Relationship with survey question
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id', 'question_id');
    }

    /**
     * Relationship with survey option (nullable for non-choice questions)
     */
    public function option(): BelongsTo
    {
        return $this->belongsTo(SurveyOption::class, 'option_id', 'option_id');
    }

    /**
     * Scopes
     */
    public function scopeByResponse($query, int $responseId)
    {
        return $query->where('response_id', $responseId);
    }

    public function scopeByQuestion($query, int $questionId)
    {
        return $query->where('question_id', $questionId);
    }

    /**
     * Get formatted answer based on question type
     */
    public function getFormattedAnswerAttribute(): ?string
    {
        if (!$this->question) {
            return $this->answer_text;
        }

        switch ($this->question->question_type) {
            case SurveyQuestion::TYPE_TEXT:
            case SurveyQuestion::TYPE_TEXTAREA:
                return $this->answer_text;
                
            case SurveyQuestion::TYPE_RADIO:
            case SurveyQuestion::TYPE_SELECT:
                return $this->option?->option_text;
                
            case SurveyQuestion::TYPE_CHECKBOX:
                // For checkbox, multiple options might be stored in additional_data
                if ($this->additional_data && isset($this->additional_data['selected_options'])) {
                    $options = SurveyOption::whereIn('option_id', $this->additional_data['selected_options'])->get();
                    return $options->pluck('option_text')->implode(', ');
                }
                return $this->option?->option_text;
                
            case SurveyQuestion::TYPE_RATING:
                return $this->rating_value ? "{$this->rating_value}/5" : null;
                
            case SurveyQuestion::TYPE_DATE:
                return $this->answer_text;
                
            default:
                return $this->answer_text;
        }
    }

    /**
     * Check if answer is empty
     */
    public function getIsEmptyAttribute(): bool
    {
        return empty($this->answer_text) 
            && empty($this->option_id) 
            && empty($this->rating_value)
            && empty($this->additional_data);
    }

    /**
     * Get answer display value for review
     */
    public function getDisplayValueAttribute(): string
    {
        if ($this->is_empty) {
            return '-';
        }

        return $this->formatted_answer ?? '-';
    }
}
