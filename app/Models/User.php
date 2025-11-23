<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
    ];

    public function loanApplications()
    {
        return $this->hasMany(LoanApplication::class);
    }
}
