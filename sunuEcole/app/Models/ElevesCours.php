<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElevesCours extends Model
{
    use HasFactory;

    

    public function salleDeClasse()
    {
        return $this->belongsTo(SalleDeClasse::class);
    }
   
}
