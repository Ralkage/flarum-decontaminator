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
        ->get('/decontaminator', 'decontaminator.index', Controller\ListPostDecontaminatorController::class)
        ->post('/decontaminator', 'decontaminator.create', Controller\CreatePostDecontaminatorController::class)
        ->get('/decontaminator/{id}', 'decontaminator.show', Controller\ShowPostDecontaminatorController::class)
        ->patch('/decontaminator/{id}', 'decontaminator.update', Controller\UpdatePostDecontaminatorController::class)
        ->delete('/decontaminator/{id}', 'decontaminator.delete', Controller\DeletePostDecontaminatorController::class),

    (new Extend\Event())
        ->listen(Saving::class, Listeners\SavePost::class)
        ->listen(Serializing::class, Listeners\LoadPost::class)
        ->listen(Started::class, Listeners\SaveDiscussion::class)
        ->listen(Renamed::class, Listeners\RenameDiscussion::class),
];
