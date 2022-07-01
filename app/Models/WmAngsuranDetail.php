<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WmAngsuranDetail extends Model
{
    use HasFactory;

    public function angsuran() {
        return $this->belongsTo(WmAngsuran::class, 'angsuran_id', 'id');
    }
}
