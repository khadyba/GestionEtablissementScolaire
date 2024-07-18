<?php

namespace App\Models;


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
        'etablissement_id',
        'is_completed'
    ];
        // public function roles()
        // {
        //     return $this->belongsToMany(Role::class);
        // }
        
        public function roles()
        {
            return $this->belongsToMany(Role::class, 'usersroles', 'user_id', 'role_id');
        }
       
        public function etablissement()
        {
            return $this->belongsTo(Etablissement::class);
        }
       
        public function professeur()
        {
            return $this->hasOne(Professeur::class, 'user_id', 'id');
        }

        
        public function eleve()
        {
            return $this->hasOne(Eleves::class, 'user_id');
        }

        public function parent()
        {
            return $this->hasOne(Parents::class, 'user_id');
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


   



 

}
