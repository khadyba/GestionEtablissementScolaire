<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends  Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $guard = 'admin';

    protected $fillable = [
        'nom',
        'prenoms',
        'adresse',
        'telephone',
        'email',
        'password',
    ];

    public function etablissement()
    {
        return $this->hasOne(Etablissement::class);
    }

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

    public function emploisDuTemps()
    {
        return $this->hasMany(EmploisDuTemps::class);
    }

}
