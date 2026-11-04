<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentBadge extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'badge_title',
        'badge_category',
        'badge_icon',
        'description',
        'awarded_date',
    ];

    protected function casts(): array
    {
        return [
            'awarded_date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
