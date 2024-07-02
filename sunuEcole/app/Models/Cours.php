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
        'fichier_cours'
    ];
    public function eleves()
    {
        return $this->belongsToMany(Eleves::class, 'eleves_cours')->withTimestamps();
    }

}
