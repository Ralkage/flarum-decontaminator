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

use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;

class PostDecontaminatorRepository
{
    /**
     * Get a new query builder for the filter table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return PostDecontaminatorModel::query();
    }

    /**
     * Find a rule by ID.
     */
    public function findOrFail($id, User $user = null)
    {
        $query = PostDecontaminatorModel::where('id', $id);

        return $this->scopeVisibleTo($query, $user)->firstOrFail();
    }

    /**
     * Scope a query to only include records that are visible to a user.
     */
    protected function scopeVisibleTo(Builder $query, User $user = null)
    {
        if ($user !== null && !$user->isAdmin()) {
            $query->whereIsHidden(0);
        }

        return $query;
    }
}
