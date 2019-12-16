<?php

namespace Tests\Unit;

use App\Models\Code;
use Tests\TestCase;

/**
 * Тест генератора кодов модели Code. © Elerance/MkSavin
 */
class CodeGenTest extends TestCase
{

    /**
     * Тест метода конвертации первичного кода в код для qr
     *
     * @return void
     */
    public function testConvertToQRCode()
    {

        self::printName("testConvertToQRCode");

        $code = base64_encode("UeuGZpTOnac5");

        $code = implode('-', str_split($code, 4));

        self::printB("VWV1-R1pw-VE9u-YWM1" . " = " . $code, "VWV1-R1pw-VE9u-YWM1" == $code);

        $this->assertEquals("VWV1-R1pw-VE9u-YWM1", $code);

    }

    /**
     * Тест метода конвертации первичного кода в код для qr
     *
     * @return void
     */
    public function testConvertFromQRCode()
    {

        self::printName("testConvertFromQRCode");

        $code = str_replace('-', '', "VWV1-R1pw-VE9u-YWM1");

        $code = base64_decode($code);

        self::printB("UeuGZpTOnac5" . " = " . $code, "UeuGZpTOnac5" == $code);

        $this->assertEquals("UeuGZpTOnac5", $code);

    }

}
