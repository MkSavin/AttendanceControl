<?php
namespace App\Helpers;

class DateTime
{

    public static function CarbonForRelativeHuman($carbon)
    {
        
        $relativeDate = $carbon->format('Y.m.d');
        if ($carbon->isYesterday()) {
            $relativeDate = "Вчера";
        } else if ($carbon->isToday()) {
            $relativeDate = "Сегодня";
        } else if ($carbon->isTomorrow()) {
            $relativeDate = "Завтра";
        }

        return $relativeDate . ", в " . $carbon->format('H:i');

    }

}
