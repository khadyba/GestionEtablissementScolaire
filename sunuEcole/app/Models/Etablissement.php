<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'directeur',
        'adresse',
        'telephone',
        'email',
        'type'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

}
