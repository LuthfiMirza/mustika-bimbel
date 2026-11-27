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
        'monthly_discount',
        'discount_reason',
        'jarimatika_level',
        'mipa_mastery_percent',
        'join_date',
        'left_date',
        'status',
        'internal_notes',
    ];

    protected function casts(): array
    {
        return [
            'monthly_discount' => 'integer',
            'jarimatika_level' => 'integer',
            'mipa_mastery_percent' => 'integer',
            'join_date' => 'date',
            'left_date' => 'date',
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

    /**
     * Net monthly SPP fee after deducting student discount.
     */
    public function getNetMonthlyFeeAttribute(): int
    {
        $base = (int) ($this->program?->monthly_fee ?? 250000);
        return max(0, $base - (int) ($this->monthly_discount ?? 0));
    }

    /**
     * Total unpaid remaining balance across all open invoices.
     */
    public function getTotalArrearsAttribute(): int
    {
        $invoices = $this->relationLoaded('invoices')
            ? $this->invoices
            : $this->invoices()->whereIn('status', ['Belum Lunas', 'Kurang'])->get();

        return (int) $invoices
            ->whereIn('status', ['Belum Lunas', 'Kurang'])
            ->sum(fn(TuitionInvoice $inv) => max(0, (int) $inv->amount - (int) ($inv->paid_amount ?? 0)));
    }
}
