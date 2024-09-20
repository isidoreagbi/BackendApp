<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',     
        'email',    
        'groupe_id',
        'user_id'
    ];

    public function groupe() {
        return $this->belongsTo(Groupe::class);
    }
    
    public function utilisateur() {
        return $this->belongsTo(User::class);
    }
    
}
