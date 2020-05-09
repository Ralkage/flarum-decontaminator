<?php

namespace Flarumite\PostDecontaminator;

use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;

class PostDecontaminatorRepository
{
    /**
     * Get a new query builder for the profanity table.
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

    public function isStaff($user_id):bool
    {
        return (bool)User::where('id', $user_id)
            ->leftJoin('group_user', 'users.id', '=', 'group_user.user_id')
            ->whereIn('group_id', [1,4]) // TODO expose these group IDs via extension settings modal
            ->count();
    }
}
