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

use Flarumite\PostDecontaminator\Api\Serializer\PostDecontaminatorSerializer;

class MockSerializer extends PostDecontaminatorSerializer
{
    public function publicGetDefaultAttributes($page)
    {
        return parent::getDefaultAttributes($page);
    }
}
