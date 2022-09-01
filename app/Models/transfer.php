<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transfer extends Model
{
    use HasFactory;
    public function fromAccountInfo()
    {
        return $this->belongsto(accountInfo::class, 'from_account_id');
    }
    public function toAccountInfo()
    {
        return $this->belongsto(accountInfo::class, 'to_acccount_id');
    }

    public function PaymentInfo()
    {
        return $this->belongsto(account::class, 'from_payment_id', 'id');
    }
}
