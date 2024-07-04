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
    return $this->belongsToMany(Professeur::class, 'nouveau_nom_table_pivot')
                ->withPivot('jour', 'heure_debut', 'heure_fin')
                ->withTimestamps();
  }


    public function eleves()
    {
        return $this->hasMany(Eleves::class);
    }
    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class);
    }

   
}
