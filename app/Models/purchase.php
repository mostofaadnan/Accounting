<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{
    use HasFactory;
    public function VendorName()
    {
        return $this->belongsto(vendor::class, 'vendor_id');
    }

    public function InvDetails()
    {
        return $this->hasMany(purchaseDetails::class, 'purchase_id');
    }
    public function username()
    {
        return $this->belongsto(User::class, 'user_id');
    }

    public function paidinfo()
    {
        return $this->hasMany(account::class, 'invoice_id')->where('payment_type', 2)
            ->where('operation_type', 2);
    }
}
