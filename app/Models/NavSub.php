<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavSub extends Model
{
    use HasFactory;

    public function navMain() {
        return $this->belongsTo(NavMain::class, 'nav_main_id', 'id');
    }

    public function navSubUser() {
        return $this->hasMany(NavSubUser::class, 'nav_sub_id', 'id');
    }

    public function navAccess() {
        return $this->hasMany(NavAccess::class, 'sub_id', 'id');
    }
}
