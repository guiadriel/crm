<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractPayment extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'contract_id',
        'sequence',
        'due_date',
        'type',
        'value',
        'status_id',
        'student_id',
        'interest',
        'bill_number',
        'bill_bank_code',
        'bill_second_generation',
        'paid_at',
        'is_registration'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function setDueDateAttribute($value)
    {
        if( $value == "" ){
            return null;
        }

        $this->attributes['due_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getDueDateAttribute()
    {
        if ('' != $this->attributes['due_date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])->format('d/m/Y');
        }

        return '';
    }

    public function setPaidAtAttribute($value)
    {
        if( $value == "" ){
            $this->attributes['paid_at'] = null;
            return;
        }

        $this->attributes['paid_at'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getPaidAtAttribute()
    {
        if ('' != $this->attributes['paid_at'] ) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['paid_at'])->format('d/m/Y');
        }

        return '';
    }
}
