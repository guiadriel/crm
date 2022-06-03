<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $number
 * @property mixed $type
 * @property mixed $start_date
 * @property mixed $payment_due_date
 * @property mixed $payment_monthly_value
 * @property mixed $payment_registration_value
 * @property mixed $observations
 * @property mixed $student_id
 * @property mixed $group_classes_id
 * @property mixed $status_id
 */
class Contract extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'type',
        'start_date',
        'school_days',
        'payment_due_date',
        'payment_total',
        'payment_monthly_value',
        'payment_registration_value',
        'payments_method_id',
        'payment_quantity',
        'student_id',
        'group_classes_id',
        'status_id',
        'observations',
        'responsible_person',
        'canceled_at',
        'reason_cancellation',
        'executed_at'
    ];

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    public function groupClass()
    {
        return $this->belongsTo('App\Models\GroupClass', 'group_classes_id');
    }

    public function payments()
    {
        return $this->hasMany(ContractPayment::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentsMethod::class, 'payments_method_id');
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

    public function setCanceledAtAttribute($value)
    {
        $this->attributes['canceled_at'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getCanceledAtAttribute()
    {
        if ('' != $this->attributes['canceled_at']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['canceled_at'])->format('d/m/Y');
        }

        return '';
    }

    public function file()
    {
        return $this->hasOne(ContractFile::class);
    }

    public function setExecutedAtAttribute($value)
    {
        $this->attributes['executed_at'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getExecutedAtAttribute()
    {
        if ('' != $this->attributes['executed_at']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['executed_at'])->format('d/m/Y');
        }

        return '';
    }
}
