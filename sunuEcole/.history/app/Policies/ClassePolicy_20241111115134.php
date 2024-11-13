<?php

namespace App\Policies;

use App\Models\Classe;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class ClassePolicy
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
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, Classe $classe)
    {
        // Si l'utilisateur est un administrateur
        if ($user instanceof \App\Models\Administrateur) {
            return Response::allow();
        }
    
        // Si l'utilisateur est un professeur et est assigné à la classe
        if ($user instanceof \App\Models\User && $classe->professeurs->contains($user)) {
            return Response::allow();
        }
    
        // Message d'erreur personnalisé si l'accès est refusé
        return Response::deny('Vous n\'êtes pas autorisé à voir les détails de cette classe.');
    }
    
    

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Classe $classe)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Classe $classe)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Classe $classe)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Classe $classe)
    {
        //
    }
}
