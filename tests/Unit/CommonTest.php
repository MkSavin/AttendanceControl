<?php

namespace Tests\Unit;

use Tests\TestCase;

class CommonTest extends TestCase
{
    /**
     * Тест проверяющий стабильность системы тестов. Имеет смысл, если система в общем упала
     *
     * @return void
     */
    public function testBasicTest()
    {
        self::printName("testBasicTest");

        print("Common stability test performs... Works?");
        $this->assertTrue(true);
    }
}
