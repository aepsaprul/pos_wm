<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesNavSub extends Model
{
    use HasFactory;

    public function navSub()
    {
        return $this->belongsTo(NavSub::class, 'nav_sub_id', 'id');
    }

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'roles_id', 'id');
    }
}
