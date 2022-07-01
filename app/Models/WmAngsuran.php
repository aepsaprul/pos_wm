<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WmAngsuran extends Model
{
    use HasFactory;

    public function nasabah() {
        return $this->belongsTo(WmNasabah::class, 'nasabah_id', 'id');
    }
}
