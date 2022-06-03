<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BooksActivity extends Model
{
    protected $fillable = [
        'name', 'number_classes', 'book_id'
    ];

    public function book()
    {
        return $this->belongsTo('App\Models\Books', 'book_id');
    }
}
