<?php

namespace Flarumite\PostDecontaminator\Api\Controller;

use Flarum\Api\Controller\AbstractListController;
use Flarum\Http\UrlGenerator;
use Flarum\Search\SearchCriteria;
use Flarum\User\AssertPermissionTrait;
use Flarumite\PostDecontaminator\Search\Page\PageSearcher;
use Flarumite\PostDecontaminator\Api\Serializer\PostDecontaminatorSerializer;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListPostDecontaminatorController extends AbstractListController
{
    use AssertPermissionTrait;
    
    /**
     * {@inheritdoc}
     */
    public $serializer = PostDecontaminatorSerializer::class;

    /**
     * {@inheritdoc}
     */
    public $sortFields = ['time', 'editTime'];

    /**
     * @var PageSearcher
     */
    protected $searcher;

    /**
     * @var UrlGenerator
     */
    protected $url;

    /**
     * @param PageSearcher $searcher
     * @param UrlGenerator $url
     */
    public function __construct(PageSearcher $searcher, UrlGenerator $url)
    {
        $this->searcher = $searcher;
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = $request->getAttribute('actor');
        $this->assertAdmin($actor);
        $query = array_get($this->extractFilter($request), 'q');
        $sort = $this->extractSort($request);
        $criteria = new SearchCriteria($actor, $query, $sort);
        $results = $this->searcher->search($criteria);

        return  $results->getResults();
    }
}
