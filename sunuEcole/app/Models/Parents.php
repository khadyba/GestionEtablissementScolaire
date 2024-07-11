<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenoms',
        'non_de_votre_éléve',
        'telephone',
        'is_completed'
      
    ];
    public function eleves()
{
    return $this->hasMany(Eleves::class);
}

}
