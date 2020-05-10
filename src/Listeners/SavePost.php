<?php

namespace Flarumite\PostDecontaminator\Listeners;

use Flarum\Post\Event\Saving;
use Flarumite\PostDecontaminator\PostDecontaminatorModel;
use Flarumite\PostDecontaminator\PostDecontaminatorRepository;
use Flarumite\PostDecontaminator\Util\DecontaminationProcessor;

class SavePost
{
    private $decontaminationProcessor;
    private $repository;

    public function __construct(DecontaminationProcessor $decontaminationProcessor, PostDecontaminatorRepository $repository)
    {
        $this->decontaminationProcessor = $decontaminationProcessor;
        $this->repository = $repository;
    }

    /**
     * @param Saving $event
     */
    public function handle(Saving $event): void
    {
        // if ($this->repository->isStaff($event->actor->id) || $this->repository->isStaff($event->post->user_id)) {
        //     return;
        // }

        if (!isset($event->data['attributes']['reaction'])) { // Add support for reactions, don't process the Saving event as we've already handled it
            PostDecontaminatorModel::query()
            ->where('event', 'save')
            ->each(function (PostDecontaminatorModel $model) use ($event) {
                $this->decontaminationProcessor->process($model, $event->post);
            });
        }
    }
}
