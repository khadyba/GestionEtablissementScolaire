<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploisDuTemps extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_path',
        'administrateur_id',
    ];

    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class);
    }
}
