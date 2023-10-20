<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return (bool)$user?->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, ...$args /*, Article $article*/): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        //
        return (bool)$user?->id && !(bool)$user?->isAdmin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user): bool
    {
        return (bool)$user?->id;
    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user): bool
    {
        //
        return (bool)$user?->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, Article $article): bool
    {
        //
        return (bool)$user?->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, Article $article): bool
    {
        //
        return (bool)$user?->id;
    }
}
