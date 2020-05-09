<?php

namespace Flarumite\PostDecontaminator\Listeners;

use Flarum\Discussion\Event\Renamed;
use Flarum\Discussion\Event\Started;
use Flarumite\PostDecontaminator\PostDecontaminatorModel;
use Flarumite\PostDecontaminator\PostDecontaminatorRepository;
use Flarumite\PostDecontaminator\Util\DecontaminationProcessor;
use Illuminate\Contracts\Events\Dispatcher;

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
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(Started::class, [$this, 'whenDiscussionIsStarted']);
        $events->listen(Renamed::class, [$this, 'whenDiscussionIsRenamed']);
    }

    /**
     * @param Started $event
     */
    public function whenDiscussionIsStarted(Started $event): void
    {
        if ($this->repository->isStaff($event->actor->id) || $this->repository->isStaff($event->discussion->user_id)) {
            return;
        }
        
        PostDecontaminatorModel::query()
            ->where('event', 'save')
            ->each(function (PostDecontaminatorModel $model) use ($event) {
                $this->decontaminationProcessor->processDiscussion($model, $event->discussion);
            });
    }

    public function whenDiscussionIsRenamed(Renamed $event):void
    {
        if ($this->repository->isStaff($event->actor->id) || $this->repository->isStaff($event->discussion->user_id)) {
            return;
        }
        
        PostDecontaminatorModel::query()
            ->where('event', 'save')
            ->each(function (PostDecontaminatorModel $model) use ($event) {
                $this->decontaminationProcessor->processDiscussion($model, $event->discussion, true);
            });
    }
}
