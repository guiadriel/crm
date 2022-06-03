<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
