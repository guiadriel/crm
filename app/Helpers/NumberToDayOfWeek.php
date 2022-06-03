<?php

namespace App\Helpers;

class NumberToDayOfWeek
{
    static public function convert($value)
    {
        $days = [
            'Domingo',
            'Segunda',
            'Terça',
            'Quarta',
            'Quinta',
            'Sexta',
            'Sábado'
        ];
        $expression = explode(",", $value);
        $vDays = [];

        foreach($expression as $dayNumber ){
            $vDays[] = $days[$dayNumber];
        }
        return join(", ", $vDays);
    }

    public static function instance()
    {
        return new NumberToDayOfWeek();
    }
}
