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

use Flarum\User\User;
use GuzzleHttp\Psr7\ServerRequest;

class MockServerRequest extends ServerRequest
{
    public function __construct()
    {
    }

    public function setActor(User $actor): self
    {
        $this->withAttribute('actor', $actor);

        return $this;
    }
}
