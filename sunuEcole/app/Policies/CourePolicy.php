<?php

namespace App\Policies;

use App\Models\Cours;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Cours $cours)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Cours $cours)
    {
        return $user->role_id === 1 && $cours->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Cours $cours)
    {
        return $user->role_id === 1 && $cours->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Cours $cours)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Cours $cours)
    {
        //
    }
}
