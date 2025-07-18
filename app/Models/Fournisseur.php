<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'fournisseurs';

    protected $fillalble = [
        'nom',
        'contact',
        'email',
        'adresse',
    ];

    public function mouvementsPapiers(){
        return $this->hasMany(MouvementPapier::class, 'fournisseur_id', 'id_fournisseur');
    }

    public function mouvementsReliures(){
        return $this->hasMany(MouvementReliure::class, 'fournisseur_id', 'id_fournisseur');
    }
}
