<?php

namespace imorland\PostDecontaminator;

use Flarum\Database\AbstractModel;

class PostDecontaminatorModel extends AbstractModel
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'profanities';

    protected $casts = [
        'id'        => 'integer'
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
