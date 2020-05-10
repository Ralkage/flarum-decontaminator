<?php

namespace Flarumite\Tests\Decontaminator\Stubs;

use Flarum\Post\Post;

class MockPost extends Post
{
    public function __construct(array $attributes = [])
    {
        $defaults = [];
        $this->attributes = $defaults;
    }

    public function getDates()
    {
        return [];
    }

    public function getCustomRelation($name)
    {
        return [];
    }
}