<?php

namespace imorland\PostDecontaminator\Listeners;

use Flarum\Post\Event\Saving;
use imorland\PostDecontaminator\PostDecontaminatorModel;
use imorland\PostDecontaminator\PostDecontaminatorRepository;
use imorland\PostDecontaminator\Util\DecontaminationProcessor;
use Illuminate\Contracts\Events\Dispatcher;

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
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(Saving::class, [$this, 'whenPostIsSaving']);
    }

    /**
     * @param Saving $event
     */
    public function whenPostIsSaving(Saving $event): void
    {
        if ($this->repository->isStaff($event->actor->id) || $this->repository->isStaff($event->post->user_id)) {
            return;
        }
        
        if (!isset($event->data["attributes"]["reaction"])) { // Add support for reactions, don't process the Saving event as we've already handled it
            PostDecontaminatorModel::query()
            ->where('event', 'save')
            ->each(function (PostDecontaminatorModel $model) use ($event) {
                $this->decontaminationProcessor->process($model, $event->post);
            });
        }
    }

}
