<?php

namespace Flarumite\PostDecontaminator\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;

class PostDecontaminatorSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'profanities';

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
