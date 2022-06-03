<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'initial_date',
        'final_date',
        'name',
        'group_classes_id',
        'book_id',
        'student_id',
        'teacher_id',
        'observation'
    ];

    public function groupClass()
    {
        return $this->belongsTo(GroupClass::class, 'group_classes_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
