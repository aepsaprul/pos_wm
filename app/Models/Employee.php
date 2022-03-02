<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function position() {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function navAccess() {
        return $this->hasMany(NavAccess::class, 'user_id', 'id');
    }
}
