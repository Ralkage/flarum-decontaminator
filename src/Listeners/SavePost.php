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

use Flarum\Post\Event\Saving;
use Flarumite\PostDecontaminator\PostDecontaminatorModel;
use Flarumite\PostDecontaminator\Util\DecontaminationProcessor;

class SavePost
{
    private $decontaminationProcessor;

    public function __construct(DecontaminationProcessor $decontaminationProcessor)
    {
        $this->decontaminationProcessor = $decontaminationProcessor;
    }

    /**
     * @param Saving $event
     */
    public function handle(Saving $event): void
    {
        if ($event->actor->hasPermission('user.bypassDecontaminator')) {
            return;
        }

        if (!isset($event->data['attributes']['reaction'])) { // Add support for reactions, don't process the Saving event as we've already handled it
            PostDecontaminatorModel::query()
            ->where('event', 'save')
            ->each(function (PostDecontaminatorModel $model) use ($event) {
                $this->decontaminationProcessor->process($model, $event->post);
            });
        }
    }
}
