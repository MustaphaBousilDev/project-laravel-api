<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function viewAny(User $user)
    {
        // Only admins can view all categories
        return $user->isAdmin();
    }

    public function view(User $user, Category $category)
    {
        // Only admins can view all categories
        return $user->isAdmin();
    }

    public function create(User $user)
    {
        // Only admins can create categories
        return $user->isAdmin();
    }

    public function update(User $user, Category $category)
    {
        // Only admins can update categories
        return $user->isAdmin();
    }

    public function delete(User $user, Category $category)
    {
        // Only admins can delete categories
        return $user->isAdmin();
    }

}
