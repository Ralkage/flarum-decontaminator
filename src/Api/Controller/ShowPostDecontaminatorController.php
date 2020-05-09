<?php

namespace Flarumite\PostDecontaminator\Api\Controller;

use Flarum\Api\Controller\AbstractShowController;
use Flarumite\PostDecontaminator\PostDecontaminatorRepository;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ShowPostDecontaminatorController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = 'imorland\PostDecontaminator\Api\Serializer\PostDecontaminatorSerializer';

    /**
     * @var PostDecontaminatorRepository
     */
    protected $pages;

    /**
     * @param PostDecontaminatorRepository $pages
     */
    public function __construct(PostDecontaminatorRepository $pages)
    {
        $this->pages = $pages;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $id = array_get($request->getQueryParams(), 'id');

        $actor = $request->getAttribute('actor');

        return $this->pages->findOrFail($id, $actor);
    }
}
