<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'Operasional',
        'Modul & ATK',
        'Sewa & Listrik',
        'Promosi',
        'Honor Pengajar',
        'Lainnya',
    ];

    protected $fillable = [
        'expense_date',
        'category',
        'description',
        'amount',
        'payment_method',
        'recorded_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'expense_date' => 'date',
            'amount' => 'integer',
        ];
    }
}
