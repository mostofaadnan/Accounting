<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;

    public function QuantityOutBySale()
    {
        return $this->hasMany(InvoiceDetails::class, 'item_id');

    }
    public function QuantityOutByPurchase()
    {
        return $this->hasMany(purchaseDetails::class, 'item_id');

    }
    public function QuantityOutBySaleReturn()
    {
        return $this->hasMany(retundDetails::class, 'item_id');

    }

    public function CategoryName()
    {
        return $this->belongsto(category::class,'category_id');
    }

}
