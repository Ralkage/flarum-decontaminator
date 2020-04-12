<?php

namespace imorland\PostDecontaminator\Api\Controller;

use Flarum\Api\Controller\AbstractShowController;
use imorland\PostDecontaminator\Command\EditProfanity;
use Illuminate\Contracts\Bus\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class UpdatePostDecontaminatorController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = 'imorland\PostDecontaminator\Api\Serializer\PostDecontaminatorSerializer';

    /**
     * @var Dispatcher
     */
    protected $bus;

    /**
     * @param Dispatcher $bus
     */
    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $id = array_get($request->getQueryParams(), 'id');
        $actor = $request->getAttribute('actor');
        $data = array_get($request->getParsedBody(), 'data');

        return $this->bus->dispatch(
            new EditProfanity($id, $actor, $data)
        );
    }
}
