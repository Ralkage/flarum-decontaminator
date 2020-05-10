<?php

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
