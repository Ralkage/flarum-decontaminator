<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\Tests\Decontaminator\Stubs;

class MockProxy
{
    private static $mock;

    public static function setStaticExpectations($mock)
    {
        self::$mock = $mock;
    }

    // Any static calls we get are passed along to self::$mock. public static
    public static function __callStatic($name, $args)
    {
        return call_user_func_array(
            [self::$mock, $name],
            $args
        );
    }
}
