<?php

namespace imorland\PostDecontaminator\Listeners;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\PostSerializer;
use imorland\PostDecontaminator\PostDecontaminatorModel;
use imorland\PostDecontaminator\Util\DecontaminationProcessor;
use Illuminate\Contracts\Events\Dispatcher;

class LoadPost
{

    private $decontaminationProcessor;

    public function __construct(DecontaminationProcessor $decontaminationProcessor)
    {
        $this->decontaminationProcessor = $decontaminationProcessor;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(Serializing::class, [$this, 'whenPostIsLoading']);
    }

    /**
     * @param  Serializing $event
     */
    public function whenPostIsLoading(Serializing $event): void
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
