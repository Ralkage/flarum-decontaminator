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
