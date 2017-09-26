<?php

namespace App\Support\Traits;

use App\User;

trait LogsActivity
{
    /**
     * Create a log of a user's action.
     *
     * @param User  $user
     * @param array $params
     */
    protected function logActivity(User $user, array $params)
    {
        $user->activity()->create($params);
    }
}
