<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_code',
        'portal_token',
        'full_name',
        'nickname',
        'grade_level',
        'class_number',
        'school_name',
        'parent_name',
        'parent_whatsapp',
        'address',
        'program_id',
        'schedule_id',
        'jarimatika_level',
        'mipa_mastery_percent',
        'join_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'jarimatika_level' => 'integer',
            'mipa_mastery_percent' => 'integer',
            'join_date' => 'date',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function studySessions(): HasMany
    {
        return $this->hasMany(StudySession::class);
    }

    public function badges(): HasMany
    {
        return $this->hasMany(StudentBadge::class);
    }

    public function tuitionInvoices(): HasMany
    {
        return $this->hasMany(TuitionInvoice::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(TuitionInvoice::class);
    }
}

