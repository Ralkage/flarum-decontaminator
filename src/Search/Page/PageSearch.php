<?php

namespace Flarumite\PostDecontaminator\Search\Page;

use Flarum\Search\AbstractSearch;

class PageSearch extends AbstractSearch
{
    /**
     * {@inheritdoc}
     */
    protected $defaultSort = ['editTime' => 'desc'];
}
