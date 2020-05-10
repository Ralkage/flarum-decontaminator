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
