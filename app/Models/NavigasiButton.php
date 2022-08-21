<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigasiButton extends Model
{
    use HasFactory;

    public function navigasiAccess() {
        return $this->hasMany(NavigasiAccess::class, 'button_id', 'id');
    }

    public function navigasiMain() {
        return $this->belongsTo(NavigasiMain::class, 'main_id', 'id');
    }

    public function navigasiSub() {
        return $this->belongsTo(NavigasiSub::class, 'sub_id', 'id');
    }
}
