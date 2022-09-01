<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function CustomerName()
    {
        return $this->belongsto(customer::class, 'customer_id');
    }

    public function InvDetails()
    {
        return $this->hasMany(InvoiceDetails::class, 'invoice_id');
    }
    public function username()
    {
        return $this->belongsto(User::class, 'user_id');
    }

    public function paidinfo()
    {
        return $this->hasMany(account::class, 'invoice_id')->where('payment_type', 1)
            ->where('operation_type', 1);
    }
}
