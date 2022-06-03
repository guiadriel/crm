<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Model Status.
 *
 * @property mixed $description
 */
class Status extends Model
{
    const STATUS_ATIVO = 'ATIVO';
    const STATUS_PROSPECTO = 'PROSPECTO';
    const STATUS_INATIVO = 'INATIVO';
    const STATUS_EM_ATRASO = 'EM ATRASO';
    const STATUS_EM_DIA = 'EM DIA';
    const STATUS_PAGO = 'PAGO';
    const STATUS_PENDENTE = 'PENDENTE';
    const STATUS_CANCELADO = 'CANCELADO';
    const STATUS_REMARKETING = 'REMARKETING';
    const STATUS_QUARENTENA = 'QUARENTENA';
    const STATUS_EXECUTADO = 'EXECUTADO';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
    ];

    public function students()
    {
        return $this->belongsToMany('App\Models\Student');
    }

    static public function getStatusPago()
    {
        return self::where('description', '=', self::STATUS_PAGO)->first();
    }

    /**
     * Function to return model by descripition
     *
     * @param  array $constant
     * @return void
     */
    static public function getIdsByConstants(array $constant)
    {
        $collections = self::whereIn('description', $constant)->get();

        return Arr::pluck($collections, 'id');

    }

    /**
     * Function to return model by descripition
     *
     * @param  string $constant
     */
    static public function getDescriptionByConstant($constant)
    {
        return self::where('description', '=', $constant)->first();
    }
}
