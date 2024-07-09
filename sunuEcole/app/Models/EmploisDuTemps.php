<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploisDuTemps extends Model
{
    use HasFactory;
    protected $fillable = [
        'emplois_du_temps',
        'administrateur_id',
        'classe_id',

    ];

    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
