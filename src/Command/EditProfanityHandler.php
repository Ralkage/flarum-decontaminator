<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\PostDecontaminator\Command;

use Flarum\User\AssertPermissionTrait;
use Flarumite\PostDecontaminator\PostDecontaminatorRepository;
use Flarumite\PostDecontaminator\PostDecontaminatorValidator;
use Illuminate\Support\Arr;

class EditProfanityHandler
{
    use AssertPermissionTrait;

    protected $pages;
    protected $validator;

    public function __construct(PostDecontaminatorRepository $pages, PostDecontaminatorValidator $validator)
    {
        $this->pages = $pages;
        $this->validator = $validator;
    }

    public function handle(EditProfanity $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $page = $this->pages->findOrFail($command->pageId, $actor);

        $this->assertAdmin($actor);

        $attributes = array_get($data, 'attributes', []);

        $page->name = Arr::get($attributes, 'name');
        $page->replacement = Arr::get($attributes, 'replacement');
        $page->regex = Arr::get($attributes, 'regex');
        $page->flag = Arr::get($attributes, 'flag');
        $page->event = Arr::get($attributes, 'event');

        $page->edit_time = time();

        $this->validator->assertValid($page->getDirty());

        $page->save();

        return $page;
    }
}
