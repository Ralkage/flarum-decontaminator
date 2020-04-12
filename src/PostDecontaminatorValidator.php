<?php

namespace imorland\PostDecontaminator;

use Flarum\Foundation\AbstractValidator;

class PostDecontaminatorValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'name' => [
            'required',
            'unique:profanities',
            'max:200',
        ],
        'regex' => [
            'required',
            'max:65535',
        ],
        'event' => [
            'required'
        ],
    ];
}
