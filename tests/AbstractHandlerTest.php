<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\Tests\Decontaminator;

use Flarum\User\User;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractHandlerTest.
 */
abstract class AbstractHandlerTest extends TestCase
{
    /**
     * @var User
     */
    protected $actor;

    /**
     * @var Mock
     */
    public $postDecontaminatorModel;

    /**
     * This method is called before each test.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->postDecontaminatorModel = \Mockery::mock('overload:'.\Flarumite\PostDecontaminator\PostDecontaminatorModel::class);
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }
}
