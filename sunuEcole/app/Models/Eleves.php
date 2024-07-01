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
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
