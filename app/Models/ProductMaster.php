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
}
