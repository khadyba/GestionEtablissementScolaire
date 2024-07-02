<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalleDeClasse extends Model
{
    use HasFactory;

    protected $fillable = [
        'numéro',
        'capaciter' ,
        'statut' ,
    ];
    public function elevesCours()
    {
        return $this->hasMany(ElevesCours::class);
    }
}
