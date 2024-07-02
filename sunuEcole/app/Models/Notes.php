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
    ];


    public function evaluation()
    {
        return $this->belongsTo(Evaluations::class);
    }

    public function eleve()
    {
        return $this->belongsTo(Eleves::class);
    }
}
