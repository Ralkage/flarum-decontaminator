<?php

namespace imorland\PostDecontaminator\Command;

use Flarum\User\User;

class CreateProfanity
{
    /**
     * The user performing the action.
     *
     * @var User
     */
    public $actor;

    /**
     * The attributes of the new filter.
     *
     * @var array
     */
    public $data;

    /**
     * @param User  $actor The user performing the action.
     * @param array $data  The attributes of the new filter.
     */
    public function __construct(User $actor, array $data)
    {
        $this->actor = $actor;
        $this->data = $data;
    }
}
