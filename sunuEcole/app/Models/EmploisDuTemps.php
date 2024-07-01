<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploisDuTemps extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
