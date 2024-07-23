<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

 
        public function handle($request, Closure $next)
        {
            // Vérifier si l'utilisateur est authentifié
            if (Auth::check()) {
                $user = Auth::user();
                $role = DB::table('usersroles')->where('user_id', $user->id)->first();
    
                if ($role) {
                    Log::info("User role detected: " . $role->role_id);
    
                    switch ($role->role_id) {
                        case 1:
                            $professeur = $user->professeur;
                            if ($professeur && !$professeur->is_completed) {
                                Log::info("Redirecting professor to complete profile.");
                                return redirect()->route('professeurs.complete-profile');
                            }
                            break;
                        case 2:
                            $eleve = $user->eleve;
                            if ($eleve && !$eleve->is_completed) {
                                Log::info("Redirecting student to complete profile.");
                                return redirect()->route('eleves.completeProfileForm');
                            }
                            break;
                        case 3:
                            $parent = $user->parent;
                            if ($parent && !$parent->is_completed) {
                                Log::info("Redirecting parent to complete profile.");
                                return redirect()->route('parents.completeProfileForm');
                            }
                            break;
                    }
                } else {
                    Log::warning("No role found for user with ID: " . $user->id);
                }
            } else {
                Log::warning("User is not authenticated.");
            }
    
            return $next($request);
        }
    }

