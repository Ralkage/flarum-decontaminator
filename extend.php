<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\PostDecontaminator;

use Flarum\Api\Event\Serializing;
use Flarum\Discussion\Event\Renamed;
use Flarum\Discussion\Event\Started;
use Flarum\Extend;
use Flarum\Post\Event\Saving;
use Flarumite\PostDecontaminator\Api\Controller;

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

    (new Extend\Event())
        ->listen(Saving::class, Listeners\SavePost::class)
        ->listen(Serializing::class, Listeners\LoadPost::class)
        ->listen(Started::class, Listeners\SaveDiscussion::class)
        ->listen(Renamed::class, Listeners\RenameDiscussion::class),
];
