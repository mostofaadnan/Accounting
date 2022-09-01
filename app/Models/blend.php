<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blend extends Model
{
    use HasFactory;

    public function InvDetails()
    {
        return $this->hasMany(blendDetails::class, 'blend_id');
    }

    public function username()
    {
        return $this->belongsto(User::class, 'user_id');
    }
    public function productName()
    {
        return $this->belongsto(item::class, 'item_id');
    }
}
