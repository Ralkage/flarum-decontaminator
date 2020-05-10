<?php

namespace Flarumite\Tests\Decontaminator\Stubs;

class PostDecontaminatorModel extends MockProxy
{
    public function getAttributes()
    {
        return [];
    }

    public function save()
    {
        return $this;
    }

    public function delete()
    {
        return true;
    }

    public function getDirty()
    {
        return [];
    }
}
