<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salary',
        'employment_type',
        'monthly_expenses',
        'is_eligible',
        'eligible_amount',
        'interest_rate',
        'tenure_months',
        'terms',
        'processing_fee',
        'status',
        'eligibility_checked_at',
    ];

    protected $casts = [
        'salary' => 'decimal:2',
        'monthly_expenses' => 'decimal:2',
        'is_eligible' => 'boolean',
        'eligible_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'eligibility_checked_at' => 'datetime',
    ];

    public const STATUS_PENDING = 'Pending';
    public const STATUS_VERIFIED = 'Verified';
    public const STATUS_APPROVED = 'Approved';
    public const STATUS_REJECTED = 'Rejected';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
