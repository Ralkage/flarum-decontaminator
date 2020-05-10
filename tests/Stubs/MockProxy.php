<?php

namespace Flarumite\Tests\Decontaminator\Stubs;

class MockProxy
{
    private static $mock;

    public static function setStaticExpectations($mock) {
        self::$mock = $mock;
    }

    // Any static calls we get are passed along to self::$mock. public static
    static function __callStatic($name, $args) {
        return call_user_func_array(
            array(self::$mock,$name), $args
        );
    }
}
