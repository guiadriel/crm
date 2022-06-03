<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const SUPER_ADMIN = 'Super Admin';

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
