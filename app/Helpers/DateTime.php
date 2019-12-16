<?php
namespace App\Helpers;

class DateTime
{

    /**
     * Форматирование даты и времени типа Carbon в человеко-понятный формат
     *
     * @param Carbon $carbon
     * @return string
     */
    public static function carbonForRelativeHuman($carbon)
    {
        if (!$carbon) {
            return "";
        }
        
        return self::carbonRelative($carbon) . ", в " . $carbon->format('H:i');
    }

    /**
     * Форматирование даты типа Carbon в относительный формат
     *
     * @param Carbon $carbon
     * @return string
     */
    public static function carbonRelative($carbon)
    {
        if (!$carbon) {
            return "";
        }

        $relativeDate = $carbon->format('Y.m.d');
        if ($carbon->isYesterday()) {
            $relativeDate = "Вчера";
        } else if ($carbon->isToday()) {
            $relativeDate = "Сегодня";
        } else if ($carbon->isTomorrow()) {
            $relativeDate = "Завтра";
        }

        return $relativeDate;
    }

}
