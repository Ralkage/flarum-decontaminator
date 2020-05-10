<?php

namespace Flarumite\PostDecontaminator\Listeners;

use Flarum\Discussion\Event\Renamed;
use Flarumite\PostDecontaminator\PostDecontaminatorModel;
use Flarumite\PostDecontaminator\PostDecontaminatorRepository;
use Flarumite\PostDecontaminator\Util\DecontaminationProcessor;

class RenameDiscussion
{
    private $decontaminationProcessor;
    private $repository;

    public function __construct(DecontaminationProcessor $decontaminationProcessor, PostDecontaminatorRepository $repository)
    {
        $this->decontaminationProcessor = $decontaminationProcessor;
        $this->repository = $repository;
    }

    public function handle(Renamed $event): void
    {
        // if ($this->repository->isStaff($event->actor->id) || $this->repository->isStaff($event->discussion->user_id)) {
        //     return;
        // }

        PostDecontaminatorModel::query()
            ->where('event', 'save')
            ->each(function (PostDecontaminatorModel $model) use ($event) {
                $this->decontaminationProcessor->processDiscussion($model, $event->discussion, true);
            });
    }
}
