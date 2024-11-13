<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cours;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
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
        return true;
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
        // Logique de vérification d'autorisation
    if (Auth::check()) {
        $roleIds = $user->roles->pluck('id')->toArray();
        return Response::allow(); if (in_array(1, $roleIds)) {
                return Response::allow();
            }
    }
        // Message personnalisé en cas de refus
        return Response::deny('Vous n\'êtes pas autorisé à voir ce cours');
            return true;
    }

    
    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
       
        if (Auth::check()) {
            $roleIds = $user->roles->pluck('id')->toArray();
            if (in_array(1, $roleIds)) {
                return Response::allow();
            }
        }

        return Response::deny('Vous n\'êtes pas autorisé à accéder à cette route');
    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Auth\Access\Response|bool
     */
    // public function update(User $user, Cours $cours)
    // {
       
    //     return $user->role_id === 1 && $cours->user_id === $user->id;
    // }


    public function update(User $user, Cours $cours)
{
    // Vérifier si l'utilisateur a le bon rôle et si le cours appartient à cet utilisateur
    if ($user->role_id !== 1 || $cours->user_id !== $user->id) {
        // Retourner une réponse avec un message d'erreur personnalisé
        return redirect()->route('professeurs.cours.list')->with('error', 'Vous n\'avez pas l\'autorisation de modifier ce cours.');
    }

     retu
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
