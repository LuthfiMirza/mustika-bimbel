<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrialLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_name',
        'whatsapp',
        'student_name',
        'grade_level',
        'school_name',
        'program_id',
        'schedule_id',
        'learning_obstacle',
        'quiz_score',
        'quiz_avg_time',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'quiz_score' => 'integer',
            'quiz_avg_time' => 'decimal:1',
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
}
