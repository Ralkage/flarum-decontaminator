<?php

namespace Flarumite\Tests\Decontaminator\Stubs;

use Flarumite\PostDecontaminator\PostDecontaminatorModel;

class MockPostDecontaminatorModel extends PostDecontaminatorModel
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