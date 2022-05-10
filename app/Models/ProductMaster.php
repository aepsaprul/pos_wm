<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaster extends Model
{
    use HasFactory;

    public function product() {
        return $this->hasMany(Product::class, 'product_master_id', 'id');
    }

    public function productCategory() {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }
}
