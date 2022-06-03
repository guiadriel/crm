<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StudentLog extends Model
{
    const TYPE_SYSTEM = 'SYSTEM';
    const TYPE_USER    = 'USER';

    const RECEIVED_SYSTEM = 'SYSTEM';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'date_log',
        'who_received',
        'description',
        'type',
        'status_id',
        'contract_id',
        'reason_cancellation'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function setDateLogAttribute($value)
    {
        $this->attributes['date_log'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
    }

    public function getDateLogAttribute()
    {
        if ('' != $this->attributes['date_log']) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['date_log'])->format('d/m/Y H:i:s');
        }

        return '';
    }
}
