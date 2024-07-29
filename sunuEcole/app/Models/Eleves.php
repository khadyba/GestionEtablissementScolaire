<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleves extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenoms',
        'adresse',
        'non_de_votre_tuteur',
        'email_tuteur',
        'dateDeNaissance',
        'classes_id',
        'parent_id',
        'is_completed'
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function cours()
    {
        return $this->belongsToMany(Cours::class, 'eleves_cours')->withTimestamps();
    }

    public function notes()
    {
        return $this->hasMany(Notes::class, 'eleve_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
{
    return $this->belongsTo(Parent::class,'email_tuteur');
}

    /**
     * Récupérer l'emploi du temps de l'élève.
     */
    public function getEmploiDuTempsAttribute()
    {
        
        if ($this->classe) {
            return $this->classe->emploisDuTemps()->first();
        }

        return null;
    }


    

}
