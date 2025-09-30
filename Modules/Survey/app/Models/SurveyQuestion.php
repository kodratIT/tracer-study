<?php

namespace Modules\Survey\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'survey_questions';
    protected $primaryKey = 'question_id';

    protected $fillable = [
        'session_id',
        'question_text',
        'question_type',
        'display_order',
        'is_required',
        'validation_rules',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'validation_rules' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Question type constants
    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_RADIO = 'radio';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_SELECT = 'select';
    const TYPE_RATING = 'rating';
    const TYPE_DATE = 'date';

    // Get all question types
    public static function getQuestionTypes(): array
    {
        return [
            self::TYPE_TEXT => 'Teks Pendek',
            self::TYPE_TEXTAREA => 'Teks Panjang',
            self::TYPE_RADIO => 'Pilihan Tunggal (Radio)',
            self::TYPE_CHECKBOX => 'Pilihan Ganda (Checkbox)',
            self::TYPE_SELECT => 'Dropdown',
            self::TYPE_RATING => 'Skala Rating',
            self::TYPE_DATE => 'Tanggal',
        ];
    }

    // Get question types that need options
    public static function getTypesWithOptions(): array
    {
        return [
            self::TYPE_RADIO,
            self::TYPE_CHECKBOX, 
            self::TYPE_SELECT,
        ];
    }

    // Get question types that are scale/rating
    public static function getRatingTypes(): array
    {
        return [
            self::TYPE_RATING,
        ];
    }

    /**
     * Relationships
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(TracerStudySession::class, 'session_id', 'session_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(SurveyOption::class, 'question_id', 'question_id')
                    ->orderBy('display_order');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'question_id', 'question_id');
    }

    /**
     * Scopes
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('question_type', $type);
    }

    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    public function scopeOptional($query)
    {
        return $query->where('is_required', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    /**
     * Accessors
     */
    public function getTypeDisplayNameAttribute(): string
    {
        return self::getQuestionTypes()[$this->question_type] ?? 'Tidak Diketahui';
    }

    public function getHasOptionsAttribute(): bool
    {
        return in_array($this->question_type, self::getTypesWithOptions());
    }

    public function getIsRatingTypeAttribute(): bool
    {
        return in_array($this->question_type, self::getRatingTypes());
    }

    public function getQuestionPreviewAttribute(): string
    {
        $preview = $this->question_text;
        
        if (strlen($preview) > 100) {
            $preview = substr($preview, 0, 100) . '...';
        }

        return $preview;
    }

    public function getRequiredLabelAttribute(): string
    {
        return $this->is_required ? 'Wajib' : 'Opsional';
    }

    public function getOptionsCountAttribute(): int
    {
        return $this->options()->count();
    }

    /**
     * Validation rules based on question type
     */
    public function getValidationRulesForType(): array
    {
        $rules = [];

        switch ($this->question_type) {
            case self::TYPE_TEXT:
                $rules = [
                    'min_length' => 'Panjang minimum karakter',
                    'max_length' => 'Panjang maksimum karakter',
                    'pattern' => 'Pola regex untuk validasi',
                ];
                break;
            
            case self::TYPE_TEXTAREA:
                $rules = [
                    'min_length' => 'Panjang minimum karakter',
                    'max_length' => 'Panjang maksimum karakter',
                    'max_words' => 'Maksimum jumlah kata',
                ];
                break;
                
            case self::TYPE_RATING:
                $rules = [
                    'min_value' => 'Nilai minimum (default: 1)',
                    'max_value' => 'Nilai maksimum (default: 5)',
                    'step' => 'Langkah nilai (default: 1)',
                ];
                break;
                
            case self::TYPE_DATE:
                $rules = [
                    'min_date' => 'Tanggal minimum',
                    'max_date' => 'Tanggal maksimum',
                ];
                break;
                
            case self::TYPE_CHECKBOX:
                $rules = [
                    'min_selections' => 'Minimum pilihan yang harus dipilih',
                    'max_selections' => 'Maksimum pilihan yang dapat dipilih',
                ];
                break;
        }

        return $rules;
    }

    /**
     * Get default validation rules for question type
     */
    public function getDefaultValidationRules(): array
    {
        switch ($this->question_type) {
            case self::TYPE_RATING:
                return [
                    'min_value' => 1,
                    'max_value' => 5,
                    'step' => 1,
                ];
                
            case self::TYPE_TEXT:
                return [
                    'max_length' => 255,
                ];
                
            case self::TYPE_TEXTAREA:
                return [
                    'max_length' => 1000,
                ];
                
            default:
                return [];
        }
    }
}
