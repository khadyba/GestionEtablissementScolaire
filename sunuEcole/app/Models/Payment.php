<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'date' ,
        'statut' ,
        'eleve_id'
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleves::class);
    }
}
