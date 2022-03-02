<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryProductIn extends Model
{
    use HasFactory;

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
