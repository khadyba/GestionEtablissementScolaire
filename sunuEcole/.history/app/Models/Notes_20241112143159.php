<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    protected $fillable = [
        'valeur',
        'appreciations' ,
        'evaluation_id' ,
        'eleve_id',
        'professeur_id',
        'professeur_id',

        'coefficient',
        'is_deleted',
    ];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluations::class);
    }
    // Définir la relation avec la classe
    public function classe()
    {
        return $this->belongsTo(Classe::class); 
    }
    public function eleve()
    {
        return $this->belongsTo(Eleves::class);
    }
}
