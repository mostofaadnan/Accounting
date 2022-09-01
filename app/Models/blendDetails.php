<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blendDetails extends Model
{
    use HasFactory;
    public function productName()
    {
        return $this->belongsto(item::class, 'item_id');
    }
}
