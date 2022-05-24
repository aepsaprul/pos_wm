<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function promo()
    {
        return $this->belongsTo(PromoProduct::class, 'promo_id', 'id');
    }
}
