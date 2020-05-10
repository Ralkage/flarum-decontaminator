<?php

namespace Flarumite\Tests\Decontaminator\Stubs;

use Flarum\User\User;

class Actor extends User
{
    protected $username = 'flarumite';
    protected $email = 'flarumite@flarumite.com';
    protected $password = 'password';
}
