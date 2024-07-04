<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasRoles; 
  
    use HasApiTokens, HasFactory,   Notifiable; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    
    protected $fillable = [
        'email',
        'password',
        'typecompte',
        'etablissement_id'

    ];
        // public function roles()
        // {
        //     return $this->belongsToMany(Role::class);
        // }
        
        public function roles()
        {
            return $this->belongsToMany(Role::class, 'usersrole', 'user_id', 'role_id');
        }
       
        public function etablissement()
        {
            return $this->belongsTo(Etablissement::class);
        }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Méthode pour attribuer le rôle en fonction du type de compte
    public function assignRole()
    {
        $roleName = '';

        switch ($this->typecompte) {
            case 'professeurs':
                $roleName = 'Professeur';
                break;
            case 'eleves':
                $roleName = 'Élève';
                break;
            case 'parents':
                $roleName = 'Parent';
                break;
           
        }

        if ($roleName) {
            $role = Role::where('nom', $roleName)->first();

            if ($role) {
                $this->roles()->sync($role);
            }
        }
    }



    protected function redirectToDashboard($user)
{
    if ($user->hasRole('professeurs')) {
        return redirect()->route('prof.dashboard');
    } elseif ($user->hasRole('eleves')) {
        return redirect()->route('eleve.dashboard');
    } elseif ($user->hasRole('parents')) {
        return redirect()->route('parent.dashboard');
    } else {
        return redirect()->route('home'); 
    }
}

}
