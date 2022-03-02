<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    public function rolesNavMain()
    {
        return $this->hasMany(RolesNavMain::class, 'roles_id', 'id');
    }

    public function rolesNavSub()
    {
        return $this->hasMany(RolesNavSub::class, 'roles_id', 'id');
    }
}
