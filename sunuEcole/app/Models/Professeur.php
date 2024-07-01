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
        'telephone'
    ];

    public function classes()
{
    return $this->belongsToMany(Classe::class, 'nouveau_nom_table_pivot')
                ->withPivot('jour', 'heure_debut', 'heure_fin')
                ->withTimestamps();
}
}
