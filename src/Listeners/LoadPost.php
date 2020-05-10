<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\PostDecontaminator\Listeners;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\PostSerializer;
use Flarumite\PostDecontaminator\PostDecontaminatorModel;
use Flarumite\PostDecontaminator\Util\DecontaminationProcessor;

class LoadPost
{
    private $decontaminationProcessor;

    public function __construct(DecontaminationProcessor $decontaminationProcessor)
    {
        $this->decontaminationProcessor = $decontaminationProcessor;
    }

    /**
     * @param Serializing $event
     */
    public function handle(Serializing $event): void
    {
        if ($event->isSerializer(PostSerializer::class)) {
            PostDecontaminatorModel::query()
                ->where('event', 'load')
                ->each(function (PostDecontaminatorModel $model) use ($event) {
                    $this->decontaminationProcessor->process($model, $event->model);

                    if ($event->model->isDirty('content')) {
                        $event->attributes['contentHtml'] = $event->model->content_html;
                    }
                });
        }
    }
}
