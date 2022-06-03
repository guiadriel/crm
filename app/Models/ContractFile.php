<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractFile extends Model
{

    protected $fillable = [
        'contract_id',
        'url',
        'content_html',
        'content_pdf'
    ];


    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
