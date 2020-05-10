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

use Flarum\Database\AbstractModel;

class PostDecontaminatorModel extends AbstractModel
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'decontaminator';

    protected $casts = [
        'id'        => 'integer',
    ];

    protected $dates = ['time', 'edit_time'];

    /**
     * Create a new Profanity Regex.
     *
     * @return static
     */
    public static function build($name, $regex, $replacement, $flag, $event)
    {
        $page = new static();

        $page->name = $name;
        $page->regex = $regex;
        $page->flag = $flag;
        $page->event = $event;
        $page->replacement = $replacement;
        $page->time = time();

        return $page;
    }
}
