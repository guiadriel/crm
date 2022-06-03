<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Undocumented class.
 *
 * @property mixed $key
 * @property mixed $value
 */
class Config extends Model
{
    const CFG_CONTRACT_COUNT = 'contract_count';

    protected $fillable = [
        'key', 'value',
    ];
}
