<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2019 Ian Morland.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\PostDecontaminator;

use Flarum\Extend;
use Flarumite\PostDecontaminator\Api\Controller;
use Flarumite\PostDecontaminator\Listeners\LoadPost;
use Flarumite\PostDecontaminator\Listeners\SavePost;
use Flarumite\PostDecontaminator\Listeners\SaveDiscussion;
use Illuminate\Contracts\Events\Dispatcher;

return [
    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\Frontend('admin'))
        ->css(__DIR__.'/resources/less/admin.less')
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Routes('api'))
        ->get('/profanities', 'profanities.index', Controller\ListPostDecontaminatorController::class)
        ->post('/profanities', 'profanities.create', Controller\CreatePostDecontaminatorController::class)
        ->get('/profanities/{id}', 'profanities.show', Controller\ShowPostDecontaminatorController::class)
        ->patch('/profanities/{id}', 'profanities.update', Controller\UpdatePostDecontaminatorController::class)
        ->delete('/profanities/{id}', 'profanities.delete', Controller\DeletePostDecontaminatorController::class),

    function (Dispatcher $events) {
        $events->subscribe(SavePost::class);
        $events->subscribe(LoadPost::class);
        $events->subscribe(SaveDiscussion::class);
    }
];
