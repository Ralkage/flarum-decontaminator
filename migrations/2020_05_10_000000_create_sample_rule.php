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
        $connection = $schema->getConnection();
        $connection->table('profanities')
            ->insert(['name' => 'Example: Wibble', 'regex' => '/wibble/mi', 'flag' => 1, 'event' => 'save', 'replacement' => '<censored>', 'time' => '2020-05-10 14:42:44']);
    },
    'down' => function (Builder $schema) {
    },
];
