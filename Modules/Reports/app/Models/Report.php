<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Survey\Models\TracerStudySession;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reports';
    
    protected $primaryKey = 'report_id';

    protected $fillable = [
        'title',
        'report_type',
        'session_id',
        'parameters',
        'status',
        'file_path',
        'file_format',
        'generated_at',
        'expires_at',
        'metadata',
    ];

    protected $casts = [
        'parameters' => 'array',
        'metadata' => 'array',
        'generated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'generated_at',
        'expires_at',
    ];

    /**
     * Report types available in the system
     */
    public const REPORT_TYPES = [
        'employment_statistics' => 'Statistik Ketenagakerjaan',
        'waiting_period' => 'Masa Tunggu Kerja',
        'job_relevance' => 'Relevansi Pekerjaan',
        'salary_analysis' => 'Analisis Gaji',
        'geographic_distribution' => 'Distribusi Geografis',
        'satisfaction_survey' => 'Survey Kepuasan',
        'response_rate' => 'Tingkat Respons',
        'alumni_tracking' => 'Pelacakan Alumni',
        'competency_analysis' => 'Analisis Kompetensi',
        'ban_pt_standard' => 'Laporan Standar BAN-PT',
    ];

    /**
     * Report status options
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_GENERATING = 'generating';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_EXPIRED = 'expired';

    /**
     * File formats supported
     */
    public const FORMAT_PDF = 'pdf';
    public const FORMAT_EXCEL = 'excel';
    public const FORMAT_CSV = 'csv';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'report_id';
    }

    /**
     * Scope for completed reports
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope for pending reports
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope for failed reports
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    /**
     * Scope by report type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('report_type', $type);
    }

    /**
     * Scope for reports that are not expired
     */
    public function scopeValid($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Check if report is completed
     */
    public function getIsCompletedAttribute()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if report is expired
     */
    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if report file exists
     */
    public function getFileExistsAttribute()
    {
        return $this->file_path && \Illuminate\Support\Facades\Storage::exists($this->file_path);
    }

    /**
     * Get download URL
     */
    public function getDownloadUrlAttribute(): string
    {
        return route('reports.download', $this->report_id);
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeHumanAttribute(): string
    {
        if (!$this->file_path || !$this->file_exists) {
            return '-';
        }
        
        $bytes = \Illuminate\Support\Facades\Storage::size($this->file_path);
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file extension
     */
    public function getFileExtensionAttribute(): string
    {
        if (!$this->file_path) {
            return '';
        }
        
        return pathinfo($this->file_path, PATHINFO_EXTENSION);
    }

    /**
     * Get report type label
     */
    public function getTypeLabel()
    {
        return self::REPORT_TYPES[$this->report_type] ?? $this->report_type;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_COMPLETED => 'success',
            self::STATUS_GENERATING => 'warning',
            self::STATUS_PENDING => 'secondary',
            self::STATUS_FAILED => 'danger',
            self::STATUS_EXPIRED => 'gray',
            default => 'gray',
        };
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_GENERATING => 'Sedang Dibuat',
            self::STATUS_PENDING => 'Menunggu',
            self::STATUS_FAILED => 'Gagal',
            self::STATUS_EXPIRED => 'Kedaluwarsa',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeAttribute()
    {
        if (!$this->file_exists) {
            return null;
        }

        $bytes = filesize(storage_path('app/' . $this->file_path));
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Relationship with tracer study session
     */
    public function session()
    {
        return $this->belongsTo(TracerStudySession::class, 'session_id', 'session_id');
    }

    /**
     * Mark report as completed
     */
    public function markAsCompleted(?string $filePath = null)
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'file_path' => $filePath,
            'generated_at' => now(),
        ]);
    }

    /**
     * Mark report as failed
     */
    public function markAsFailed(?string $error = null)
    {
        $metadata = $this->metadata ?? [];
        if ($error) {
            $metadata['error'] = $error;
        }

        $this->update([
            'status' => self::STATUS_FAILED,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Set expiration date
     */
    public function setExpiration(int $days = 30)
    {
        $this->update([
            'expires_at' => now()->addDays($days),
        ]);
    }
}
