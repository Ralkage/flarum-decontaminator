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

use Flarum\Foundation\AbstractValidator;

class PostDecontaminatorValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'name' => [
            'required',
            'unique:decontaminator',
            'max:200',
        ],
        'regex' => [
            'required',
            'max:65535',
        ],
        'event' => [
            'required',
        ],
    ];
}
