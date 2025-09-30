<?php

namespace Modules\Survey\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyOption extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'survey_options';
    protected $primaryKey = 'option_id';

    protected $fillable = [
        'question_id',
        'option_text',
        'weight',
        'display_order',
    ];

    protected $casts = [
        'weight' => 'integer',
        'display_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id', 'question_id');
    }

    /**
     * Scopes
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function scopeByQuestion($query, int $questionId)
    {
        return $query->where('question_id', $questionId);
    }

    /**
     * Accessors
     */
    public function getOptionPreviewAttribute(): string
    {
        $preview = $this->option_text;
        
        if (strlen($preview) > 50) {
            $preview = substr($preview, 0, 50) . '...';
        }

        return $preview;
    }

    public function getWeightDisplayAttribute(): string
    {
        return $this->weight > 0 ? "+{$this->weight}" : (string) $this->weight;
    }
}
