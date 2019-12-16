<?php

namespace Tests\Unit;

use App\Helpers\DateTime;
use Tests\TestCase;
use \Carbon\Carbon;

/**
 * Тест хелпера DateTime. © Elerance/MkSavin
 */
class DateTimeTest extends TestCase
{

    /**
     * Тест метода форматирования даты типа Carbon в относительный формат
     *
     * @return void
     */
    public function testCarbonRelative()
    {

        self::printName("testCarbonRelative");

        $date = DateTime::carbonRelative(null);
        self::printB("" . " = " . $date, "" == $date);
        $this->assertEquals("", $date);

        $date = DateTime::carbonRelative(Carbon::now());
        self::printB("Сегодня" . " = " . $date, "Сегодня" == $date);
        $this->assertEquals("Сегодня", $date);


    }

    /**
     * Тест метода форматирования даты и времени типа Carbon в человеко-понятный формат
     *
     * @return void
     */
    public function testCarbonForRelativeHuman()
    {

        self::printName("testCarbonForRelativeHuman");

        $date = DateTime::carbonForRelativeHuman(null);
        self::printB("" . " = " . $date, "" == $date);
        $this->assertEquals("", $date);

        $carbon = Carbon::now();
        $date = DateTime::carbonForRelativeHuman($carbon);
        self::printB("Сегодня, в " . $carbon->format('H:i') . " = " . $date, "Сегодня, в " . $carbon->format('H:i') == $date);
        $this->assertEquals("Сегодня, в " . $carbon->format('H:i'), $date);

    }

}
