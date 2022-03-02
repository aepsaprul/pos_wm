<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavAccess extends Model
{
    use HasFactory;

    public function navMain() {
        return $this->belongsTo(NavMain::class, 'main_id', 'id');
    }

    public function navSub() {
        return $this->belongsTo(NavSub::class, 'sub_id', 'id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'user_id', 'id');
    }
}
