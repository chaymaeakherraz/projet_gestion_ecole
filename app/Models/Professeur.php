<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cours; // <-- هادي خاصك تزيدها

class Professeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'specialite'
    ];

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}

