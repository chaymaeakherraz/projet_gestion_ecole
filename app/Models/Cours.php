<?php

// app/Models/Cours.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'description', 'fichier_pdf', 'professeur_id'
    ];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }
}
