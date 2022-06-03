<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Fillable property of bills
     *
     * @var array
     */
    protected $fillable = [
        "category_id",
        "sub_category_id",
        "type",
        "description",
        "expected_date",
        "paid",
        "paid_at",
        "paid_by",
        "amount",
        "status_id",
        'contract_id',
        'contract_payment_id'
    ];

    /**
     * Contract Relationship
     *
     * @return void
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }


    /**
     * Contract Relationship
     *
     * @return void
     */
    public function contractPayment()
    {
        return $this->belongsTo(ContractPayment::class, 'contract_payment_id');
    }


    /**
     * Category Relationship
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Subcategory Relationship
     *
     * @return void
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Status Relationship
     *
     * @return void
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }


    /**
     * Method to convert format PT-BR to EN
     *
     * @param  mixed $value
     * @return void
     */
    public function setExpectedDateAttribute($value)
    {
        if( $value == "" ){
            return null;
        }

        $this->attributes['expected_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getExpectedDateAttribute()
    {
        if ('' != $this->attributes['expected_date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['expected_date'])->format('d/m/Y');
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
