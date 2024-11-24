<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classe_professeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'professeur_id',
        'classe_id',
    ];
    protected $table = 'classe_professeur';


}
