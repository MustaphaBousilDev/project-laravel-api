<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Plante;
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

    public function update(User $user, Plante $plante)
    {
        return $user->id === $plante->user_id ||  $user->isAdmin();
    }

    public function delete(User $user, Plante $plante)
    {
        return $user->id === $plante->user_id ||  $user->isAdmin();
    }
}
