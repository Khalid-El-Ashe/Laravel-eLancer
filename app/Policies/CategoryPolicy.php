<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    // public function before(User $user, $ability)
    // {
    // if ($user->id == 1) {
    //     return true;
    // }
    // if ($user->type == 'superAdmin') {
    //     return true;
    // }
    // }

    public function viewAny(User $user)
    {
        return $user->hasAbility('categories.view');
    }

    public function view(User $user, Category $category)
    {
        return $user->hasAbility('categories.view');
    }

    public function create(User $user)
    {
        return $user->hasAbility('categories.create');
    }

    public function update(User $user, Category $category)
    {
        return $user->hasAbility('categories.update');
    }

    public function delete(User $user, Category $category)
    {
        return $user->hasAbility('categories.delete'); //&& $category->user_id == $user->id;
    }

    public function restore(User $user, Category $category)
    {
        return $user->hasAbility('categories.restore');
    }

    public function forceDelete(User $user, Category $category)
    {
        return $user->hasAbility('categories.forceDelete');
    }
}
