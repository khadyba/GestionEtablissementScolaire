<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'descriptions',
        'jours',
        'heure_debut',
        'heure_fin',
        'fichier_cours',
        'professeurs_id',
        'classes_id',
        'is_deleted'

    ];
    public function eleves()
    {
        return $this->belongsToMany(Eleves::class, 'eleves_cours')->withTimestamps();
    }

    public function professeur()
{
    return $this->belongsTo(Professeur::class);
}

public function salleDeClasse()
{
    return $this->belongsTo(SalleDeClasse::class);
}

}
