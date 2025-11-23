<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'Pending';
    public const STATUS_RECEIVED = 'Received';
    public const STATUS_VERIFIED = 'Verified';
    public const STATUS_REJECTED = 'Rejected';

    protected $fillable = [
        'loan_application_id',
        'amount',
        'transaction_id',
        'payment_method',
        'status',
        'confirmation_path',
        'paid_at',
        'meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'meta' => 'array',
    ];

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class);
    }
}
