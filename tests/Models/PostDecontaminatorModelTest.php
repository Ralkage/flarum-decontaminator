<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\Tests\Decontaminator\Models;

use Flarumite\PostDecontaminator\PostDecontaminatorModel;
use Flarumite\Tests\Decontaminator\Stubs\MockPostDecontaminatorModel;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class PostDecontaminatorModelTest extends TestCase
{
    const name = 'Rule';
    const regex = '/strawberry/mi';
    const replacement = 'raspberry';
    const flag = true;
    const event = false;

    /**
     * @group unit
     */
    public function testModelBuildContainsExpectedParamaters(): void
    {
        $model = new MockPostDecontaminatorModel();

        $this->assertInstanceOf(PostDecontaminatorModel::class, $model);

        $result = $model->build(self::name, self::regex, self::replacement, self::flag, self::event);

        $this->assertEquals(self::name, $result->name);
        $this->assertEquals(self::regex, $result->regex);
        $this->assertEquals(self::replacement, $result->replacement);
        $this->assertEquals(self::flag, $result->flag);
        $this->assertEquals(self::event, $result->event);
        $this->assertArrayHasKey('time', $result);
        $this->assertEquals(['name', 'regex', 'flag', 'event', 'replacement', 'time'], array_keys($result->toArray()));
    }
}
