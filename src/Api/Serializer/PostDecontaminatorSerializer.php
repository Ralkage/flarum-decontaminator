<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\PostDecontaminator\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;

class PostDecontaminatorSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'decontaminator';

    /**
     * {@inheritdoc}
     */
    protected function getDefaultAttributes($page): array
    {
        $attributes = [];

        if ($this->actor->isAdmin()) {
            $attributes = [
                'id'          => $page->id,
                'name'        => $page->name,
                'flag'        => $page->flag,
                'event'       => $page->event,
                'replacement' => $page->replacement,
                'regex'       => $page->regex,
                'time'        => $page->time,
                'editTime'    => $page->edit_time,

            ];
        }

        return $attributes;
    }
}
