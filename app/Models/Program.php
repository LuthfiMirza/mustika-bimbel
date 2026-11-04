<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'target_grade',
        'category',
        'highlights',
        'monthly_fee',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'monthly_fee' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function trialLeads(): HasMany
    {
        return $this->hasMany(TrialLead::class);
    }
}
