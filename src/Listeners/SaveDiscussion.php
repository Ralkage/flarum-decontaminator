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

use Flarum\Discussion\Event\Started;
use Flarumite\PostDecontaminator\PostDecontaminatorModel;
use Flarumite\PostDecontaminator\PostDecontaminatorRepository;
use Flarumite\PostDecontaminator\Util\DecontaminationProcessor;

class SaveDiscussion
{
    private $decontaminationProcessor;
    private $repository;

    public function __construct(DecontaminationProcessor $decontaminationProcessor, PostDecontaminatorRepository $repository)
    {
        $this->decontaminationProcessor = $decontaminationProcessor;
        $this->repository = $repository;
    }

    /**
     * @param Started $event
     */
    public function handle(Started $event): void
    {
        // if ($this->repository->isStaff($event->actor->id) || $this->repository->isStaff($event->discussion->user_id)) {
        //     return;
        // }

        PostDecontaminatorModel::query()
            ->where('event', 'save')
            ->each(function (PostDecontaminatorModel $model) use ($event) {
                $this->decontaminationProcessor->processDiscussion($model, $event->discussion);
            });
    }
}
