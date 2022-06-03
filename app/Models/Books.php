<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $fillable = [
        'name', 'total_activities',
    ];

    public function activities()
    {
        return $this->hasMany(BooksActivity::class, 'book_id');
    }
}
