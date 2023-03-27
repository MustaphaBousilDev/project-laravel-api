<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Plant;
class PlantePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function view(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->role === 1 ||  $user->isAdmin();
    }

    public function update(User $user, Plant $plant)
    {
        return $user->id === $plant->user_id ||  $user->isAdmin();
    }

    public function delete(User $user, Plant $plant)
    {
        return $user->id === $plant->user_id ||  $user->isAdmin();
    }
}
