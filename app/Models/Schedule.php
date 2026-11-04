<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'session_name',
        'days_text',
        'start_time',
        'end_time',
        'max_quota',
        'filled_quota',
    ];

    protected function casts(): array
    {
        return [
            'max_quota' => 'integer',
            'filled_quota' => 'integer',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function trialLeads(): HasMany
    {
        return $this->hasMany(TrialLead::class);
    }

    public function studySessions(): HasMany
    {
        return $this->hasMany(StudySession::class);
    }

    public function getRemainingQuotaAttribute(): int
    {
        return max(0, $this->max_quota - $this->filled_quota);
    }
}

