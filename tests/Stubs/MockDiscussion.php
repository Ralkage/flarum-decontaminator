<?php

namespace Flarumite\Tests\Decontaminator\Stubs;

use Flarum\Discussion\Discussion;

class MockDiscussion extends Discussion
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