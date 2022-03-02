<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesNavMain extends Model
{
    use HasFactory;

    public function navMain()
    {
        return $this->belongsTo(NavMain::class, 'nav_main_id', 'id');
    }

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'roles_id', 'id');
    }
}
