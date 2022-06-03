<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupClass extends Model
{
    use HasFactory;

    const TYPE_TURMA = 'TURMA';
    const TYPE_VIP   = 'VIP';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status_id',
        'number_vacancies',
        'number_vacancies_demo',
        'day_of_week',
        'time_schedule',
        'teacher_id',
        'start_date',
        'type'
    ];

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'group_classes_students', 'group_classes_id', 'student_id');
    }

    public function paragraphs()
    {
        return $this->hasMany(Paragraph::class, 'group_classes_id');
    }

    public function frequencies()
    {
        return $this->hasMany(StudentFrequency::class, 'group_classes_id');
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getStartDateAttribute()
    {
        if ('' != $this->attributes['start_date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['start_date'])->format('d/m/Y');
        }

        return '';
    }

    public function getTimeScheduleAttribute()
    {
        if ('' != $this->attributes['time_schedule']) {
            return Carbon::createFromFormat('H:i:s', $this->attributes['time_schedule'])->format('H:i');

        }

        return '';
    }
}
