<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsible extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'gender',
        'email',
        'phone',
        'phone_message',
        'rg',
        'cpf',
        'zip_code',
        'address',
        'number',
        'neighborhood',
        'city',
        'state',
        'student_id',
        'birthday_date'
    ];

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function setBirthdayDateAttribute($value)
    {
        if ('' != $value )
            $this->attributes['birthday_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getBirthdayDateAttribute()
    {
        if ('' != $this->attributes['birthday_date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['birthday_date'])->format('d/m/Y');
        }

        return '';
    }
}
