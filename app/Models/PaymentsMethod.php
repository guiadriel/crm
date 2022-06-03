<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentsMethod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'status_id',
        'category_id',
        'sub_category_id'
    ];

    /**
     * The Status Model
     *
     * @return void
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    /**
     * The Category Model
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * The SubCategory Model
     *
     * @return void
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    static public function getActiveMethods()
    {
        $activeStatus = Status::whereIn('description', [Status::STATUS_ATIVO])->first();
        return self::all()->where('status_id', '=', $activeStatus->id);
    }

}
