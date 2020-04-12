<?php

namespace imorland\PostDecontaminator\Api\Controller;

use Flarum\Api\Controller\AbstractCreateController;
use imorland\PostDecontaminator\Command\CreateProfanity;
use imorland\PostDecontaminator\Api\Serializer\PostDecontaminatorSerializer;
use Illuminate\Contracts\Bus\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class CreatePostDecontaminatorController extends AbstractCreateController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = PostDecontaminatorSerializer::class;

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
        return $this->bus->dispatch(
            new CreateProfanity($request->getAttribute('actor'), array_get($request->getParsedBody(), 'data'))
        );
    }
}
