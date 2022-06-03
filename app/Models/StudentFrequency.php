<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentFrequency extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The protected fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'group_classes_id',
        'class_date',
        'is_attend'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function groupClass()
    {
        return $this->belongsTo(GroupClass::class, 'group_classes_id');
    }

    /**
     * Convert Date Attribute PT-BR to EN
     *
     * @param  mixed $value
     * @return void
     */
    public function setClassDateAttribute($value)
    {
        if ('' != $value){
            $this->attributes['class_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }

    }

    /**
     * * Convert Date Attribute EN to PT-BR
     *
     * @return void
     */
    public function getClassDateAttribute()
    {
        if ('' != $this->attributes['class_date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['class_date'])->format('d/m/Y');
        }

        return '';
    }

}
