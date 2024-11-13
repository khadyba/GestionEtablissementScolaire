<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluations extends Model
{
    use HasFactory;

    protected $fillable = [
        '',
        'type' ,
        'jours',
        'heure_debut',
        'heure_fin',
        'professeur_id',
    ];

    public function notes()
    {
        return $this->hasMany(Notes::class);
    }

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }

}
