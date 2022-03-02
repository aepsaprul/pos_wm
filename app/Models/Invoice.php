<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function sales() {
        return $this->hasMany(Sales::class, 'invoice_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
