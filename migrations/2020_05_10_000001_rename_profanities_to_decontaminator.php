<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        if ($schema->hasTable('decontaminator')) {
            return;
        }

        $schema->rename('profanities', 'decontaminator');
    },
    'down' => function (Builder $schema) {
        $schema->rename('decontaminator', 'profanities');
        
    },
];
