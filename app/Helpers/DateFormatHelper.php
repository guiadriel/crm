<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateFormatHelper
{
    public static function convertToBR($date)
    {
        if( $date !== "" ){
            return  Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
        }
    }

    public static function convertToEN($date)
    {
        if( $date !== "" ){
            return  Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        }
    }

    public static function instance()
    {
        return new CurrencyHelper();
    }
}
