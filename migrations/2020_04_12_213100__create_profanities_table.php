<?php

use Flarum\Database\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        if ($schema->hasTable('profanities')) {
            return;
        }

        $schema->create('profanities', function (Blueprint $table) use ($schema) {
            $table->increments('id');

            $table->string('type', 200);
            $table->string('name', 200);
            $table->boolean('flag');
            $table->string('event', 200);
            $table->string('replacement', 200);
            $table->dateTime('time');
            $table->dateTime('edit_time')->nullable();
            $table->text('regex');
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('profanities');
    },
];
