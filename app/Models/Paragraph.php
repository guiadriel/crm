<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paragraph extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Fillable values of Paragraph
     *
     * @var array
     */
    protected $fillable = [
        "group_classes_id",
        "date",
        "page",
        "book_id",
        "last_word",
        "activity",
        "observation",
        "teacher_id"
    ];

    /**
     * The GroupClass relationship
     *
     * @return void
     */
    public function groupClass()
    {
        return $this->belongsTo(GroupClass::class, 'group_classes_id');
    }

    /**
     * The teacher relationship
     *
     * @return void
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * The book relationship
     *
     * @return void
     */
    public function book()
    {
        return $this->belongsTo(Books::class);
    }

    /**
     * Convert Date Attribute PT-BR to EN
     *
     * @param  mixed $value
     * @return void
     */
    public function setDateAttribute($value)
    {
        if ('' != $value )
            $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    /**
     * * Convert Date Attribute EN to PT-BR
     *
     * @return void
     */
    public function getDateAttribute()
    {
        if ('' != $this->attributes['date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['date'])->format('d/m/Y');
        }

        return '';
    }

}
