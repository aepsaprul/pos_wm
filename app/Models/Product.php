<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function inventoryProductIn() {
        return $this->hasMany(InventoryProductIn::class, 'product_id', 'id');
    }

    public function inventoryProductOut() {
        return $this->hasMany(InventoryProductOut::class, 'product_id', 'id');
    }

    public function inventoryStock() {
        return $this->hasMany(InventoryStock::class, 'product_id', 'id');
    }

    public function shopStock() {
        return $this->hasMany(ShopStock::class, 'product_id', 'id');
    }

    public function productMaster() {
        return $this->belongsTo(ProductMaster::class, 'product_master_id', 'id');
    }

    public function productShop() {
        return $this->hasMany(ProductShop::class, 'product_id', 'id');
    }
}
