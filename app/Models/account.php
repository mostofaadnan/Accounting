<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class account extends Model
{
    use HasFactory;
    public function AccountInfo()
    {
        return $this->belongsto(accountInfo::class, 'account_id');
    }

    public function InvoiceNo()
    {
        return $this->belongsto(Invoice::class, 'invoice_id', 'id');
    }
    public function purchaseNo()
    {
        return $this->belongsto(purchase::class, 'invoice_id', 'id');
    }

    public function ExpenseInfo()
    {
        return $this->belongsto(Expense::class, 'invoice_id', 'id');
    }
    public function Transfeinfo()
    {
        return $this->belongsto(transfer::class, 'invoice_id', 'id');
    }

}
