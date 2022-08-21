<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigasiMain extends Model
{
    use HasFactory;

    public function navigasiButton() {
        return $this->hasMany(NavigasiButton::class, 'main_id', 'id');
    }

    public function navigasiSub() {
        return $this->hasMany(NavigasiSub::class, 'main_id', 'id');
    }
}
