<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluations extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'type' ,
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
