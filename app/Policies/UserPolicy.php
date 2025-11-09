<?php

namespace App\Policies;

use App\Models\User;


class UserPolicy
{
    public function ban(User $user, User $target)
    {
        return $user->isMaster() && !$target->isMaster();
    }

    public function unban(User $user, User $target)
    {
        return $user->isMaster() && !$target->isMaster();
    }

    public function accessMasterPanel(User $user)
    {
        return $user->isMaster() || $user->isModerator();
    }
}
