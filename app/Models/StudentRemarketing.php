<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRemarketing extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'contact_date',
        'who_contacted',
        'type'
    ];

    public function setContactDateAttribute($value)
    {
        if ('' != $value )
            $this->attributes['contact_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getContactDateAttribute()
    {
        if ('' != $this->attributes['contact_date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['contact_date'])->format('d/m/Y');
        }

        return '';
    }

}
