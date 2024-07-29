<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'niveau',
        'etablissement_id',
        'administrateur_id',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }
public function professeurs()
{
    return $this->belongsToMany(Professeur::class, 'classe_professeur', 'classe_id', 'professeur_id');
}


    public function eleve()
    {
        return $this->hasMany(Eleves::class, 'classe_id');
    }
    
    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class);
    }
    public function emploisDuTemps()
    {
        return $this->hasMany(EmploisDuTemps::class);
    }
    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}
