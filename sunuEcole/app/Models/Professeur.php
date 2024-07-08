<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenoms',
        'spécialiter',
        'adresse',
        'telephone',
         'user_id'
    ];

    // public function classes()
    // {
    //     return $this->belongsToMany(Classe::class, 'nouveau_nom_table_pivot')
    //                 ->withPivot('jour', 'heure_debut', 'heure_fin')
    //                 ->withTimestamps();
    // }

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_professeur', 'professeur_id', 'classe_id');
    }
    
    public function evaluations()
    {
        return $this->hasMany(Evaluations::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
