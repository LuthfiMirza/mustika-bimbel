<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TuitionInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'student_id',
        'billing_period',
        'billing_month',
        'base_amount',
        'discount_amount',
        'amount',
        'paid_amount',
        'due_date',
        'status',
        'paid_at',
        'payment_method',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'base_amount' => 'integer',
            'discount_amount' => 'integer',
            'amount' => 'integer',
            'paid_amount' => 'integer',
            'due_date' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(InvoicePayment::class)->orderBy('payment_date', 'desc')->orderBy('id', 'desc');
    }

    /**
     * Remaining balance that still needs to be paid.
     */
    public function getRemainingAmountAttribute(): int
    {
        return max(0, (int) $this->amount - (int) ($this->paid_amount ?? 0));
    }

    /**
     * Recalculate paid_amount and invoice status from recorded payments.
     */
    public function syncPaymentStatus(?string $lastMethod = null, ?string $notes = null): void
    {
        $totalPaid = (int) $this->payments()->sum('amount');
        $this->paid_amount = $totalPaid;

        if ($totalPaid <= 0) {
            $this->status = 'Belum Lunas';
            $this->paid_at = null;
        } elseif ($totalPaid < $this->amount) {
            $this->status = 'Kurang';
            $this->paid_at = now();
        } else {
            $this->status = 'Lunas';
            $this->paid_at = now();
        }

        if ($lastMethod) {
            $this->payment_method = $lastMethod;
        }

        if ($notes !== null && $notes !== '') {
            $this->notes = $notes;
        }

        $this->save();
    }
}
