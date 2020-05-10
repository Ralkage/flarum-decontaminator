<?php

/*
 * This file is part of flarumite/flarum-decontaminator.
 *
 * Copyright (c) 2020 Flarumite.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarumite\PostDecontaminator\Command;

use Flarum\User\User;

class DeleteProfanity
{
    /**
     * The ID of the page to delete.
     *
     * @var int
     */
    public $pageId;

    /**
     * The user performing the action.
     *
     * @var User
     */
    public $actor;

    /**
     * Any other page input associated with the action. This is unused by
     * default, but may be used by extensions.
     *
     * @var array
     */
    public $data;

    /**
     * @param int   $pageId The ID of the page to delete.
     * @param User  $actor  The user performing the action.
     * @param array $data   Any other page input associated with the action. This
     *                      is unused by default, but may be used by extensions.
     */
    public function __construct($pageId, User $actor, array $data = [])
    {
        $this->pageId = $pageId;
        $this->actor = $actor;
        $this->data = $data;
    }
}
