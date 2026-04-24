<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificat extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'type',
        'statut',
    ];

    // العلاقة مع جدول etudiants
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
