<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'schedule_id',
        'session_date',
        'check_in_time',
        'check_out_time',
        'attendance_status',
        'subject_category',
        'topic_covered',
        'speed_rating',
        'practice_score',
        'tutor_notes',
        'wa_arrival_sent',
        'wa_report_sent',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
            'speed_rating' => 'integer',
            'practice_score' => 'integer',
            'wa_arrival_sent' => 'boolean',
            'wa_report_sent' => 'boolean',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
