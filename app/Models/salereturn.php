<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salereturn extends Model
{
    use HasFactory;
    public function CustomerName()
    {
        return $this->belongsto(customer::class, 'customer_id');
    }

    public function InvDetails()
    {
        return $this->hasMany(retundDetails::class, 'return_id');
    }
    public function username()
    {
        return $this->belongsto(User::class, 'user_id');
    }

    public function AdjustmentInvoice()
    {
        return $this->belongsto(Invoice::class, 'invoice_trn_no');
    }
    public function CashReturn()
    {
        return $this->belongsto(account::class, 'invoice_trn_no');
    }
}