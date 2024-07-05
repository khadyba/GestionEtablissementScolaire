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
        'dateDeNaissance',
        'classes_id'
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
        return $this->hasMany(Notes::class);
    }

    // methode pour calculer la moyenne semestrielle de l'eleves 

    public function moyenneSemestrielle($semestre)
    {
        $notes = $this->notes()->where('semestre', $semestre)->get();
        if ($notes->isEmpty()) {
            return null; 
        }
        $total = $notes->sum('valeur');
        $count = $notes->count();
        return $total / $count;
    }
//   methode pour avoir le bultin de l'eleves
    public function bulletinDeNotes($semestre)
    {
        $notes = $this->notes()->where('semestre', $semestre)->get();
        $moyenne = $this->moyenneSemestrielle($semestre);

        return [
            'eleve' => $this->prenom, 
            'semestre' => $semestre,
            'notes' => $notes,
            'moyenne' => $moyenne,
        ];
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
}
