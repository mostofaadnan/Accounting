<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseReturn extends Model
{
    use HasFactory;

    public function VendorName()
    {
        return $this->belongsto(vendor::class, 'vendor_id');
    }

    public function InvDetails()
    {
        return $this->hasMany(purchaseReturnDetails::class, 'return_id');
    }
    public function username()
    {
        return $this->belongsto(User::class, 'user_id');
    }

    public function AdjustmentInvoice()
    {
        return $this->belongsto(purchase::class, 'purchase_trn_no');
    }
    public function CashReturn()
    {
        return $this->belongsto(account::class, 'purchase_trn_no');
    }
}
