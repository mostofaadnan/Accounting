<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public function PaymentInfo()
    {
        return $this->belongsto(account::class, 'payment_id', 'id');
    }
}