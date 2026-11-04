<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TuitionInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'student_id',
        'billing_period',
        'amount',
        'due_date',
        'status',
        'paid_at',
        'payment_method',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'due_date' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
