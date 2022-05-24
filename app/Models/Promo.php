<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    public function promoProduct() {
        return $this->hasMany(PromoProduct::class, 'promo_id', 'id');
    }
}
