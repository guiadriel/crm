<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
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
        "due_date",
        "paid",
        "paid_at",
        "paid_by",
        "amount",
        "intended_amount",
        "interest",
        "status_id",
        "has_installments",
        "sequence",
        "referer_id",
        "observations"
    ];

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
     * Convert Due Date Attribute PT-BR to EN
     *
     * @param  mixed $value
     * @return void
     */
    public function setDueDateAttribute($value)
    {
        if ('' != $value )
            $this->attributes['due_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    /**
     * * Convert Due Date Attribute EN to PT-BR
     *
     * @return void
     */
    public function getDueDateAttribute()
    {
        if ('' != $this->attributes['due_date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])->format('d/m/Y');
        }

        return '';
    }

    /**
     * Convert Paid At Attribute PT-BR to EN
     *
     * @param  mixed $value
     * @return void
     */
    public function setPaidAtAttribute($value)
    {
        if ('' != $value )
            $this->attributes['paid_at'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    /**
     * Convert Paid At ATtribute EN to PT-BR
     *
     * @return void
     */
    public function getPaidAtAttribute()
    {
        if ('' != $this->attributes['paid_at']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['paid_at'])->format('d/m/Y');
        }

        return '';
    }


    /**
     * Return a total of installments
     *
     * @return void
     */
    public function getTotalInstallments()
    {
        return self::where('referer_id', $this->attributes['referer_id'])->count();
    }

}
