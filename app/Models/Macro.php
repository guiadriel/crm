<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Macro extends Model
{
    //
    protected $fillable = [
        'name',
        'macro',
        'group'
    ];
}
