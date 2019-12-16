<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use WithoutMiddleware;

    public static function printName($str) {
        print("\n" . $str . ":" . "\n");
    }
    public static function printB($str, $bool) {
        print("\n" . $str . " -> " . ($bool ? "true" : "false") . "\n");
    }

}
