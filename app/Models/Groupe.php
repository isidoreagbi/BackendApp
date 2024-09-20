<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description', // Ajoute d'autres attributs si nécessaire
    ];

    public function membres() {
        return $this->hasMany(Membre::class);
    }
    
}
