<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];


    const TYPE_INCOME = 'income';
    const TYPE_OUTCOME = 'outcome';

    protected $fillable = [
        'description',
        'observations',
        'type',
        'value',
        'status_id',
        'category_id',
        'sub_category_id',
        'contract_id',
        'contract_payment_id',
        'user_id',
        'student_id',
        'bill_id',
        'receipt_id',
        'payment_method',
        'payment_date',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

     public function setPaymentDateAttribute($value)
    {
        if( $value == "" ){
            $this->attributes['payment_date'] = null;
            return;
        }

        $this->attributes['payment_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getPaymentDateAttribute()
    {
        if ('' != $this->attributes['payment_date'] ) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['payment_date'])->format('d/m/Y');
        }

        return '';
    }
}
