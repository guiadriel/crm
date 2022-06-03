<?php

namespace App\Helpers;

class OnlyNumbersOfString
{
    public static function format($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
    }

    public static function instance()
    {
        return new OnlyNumbersOfString();
    }
}
