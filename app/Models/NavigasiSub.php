<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigasiSub extends Model
{
    use HasFactory;

    public function navigasiMain() {
        return $this->belongsTo(NavigasiMain::class, 'main_id', 'id');
    }

    public function navigasiButton() {
        return $this->hasMany(NavigasiButton::class, 'sub_id', 'id');
    }
}
