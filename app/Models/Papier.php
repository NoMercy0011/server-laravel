<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papier extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $primaryKey = 'id_papier';

    protected $table = 'papiers';

    protected $fillable = [
        'categorie',
        'accessoire',
    ];

    public  function categorie(){
        return $this->belongsTo(Categorie::class, 'categorie_id', 'id_categorie' );
    }
    public function accessoire(){
        return $this->belongsTo(Accessoire::class, 'accessoire_id', 'id_accessoire');
    }
    public function couleur(){
        return $this->belongsTo(Couleur::class, 'couleur_id', 'id_couleur');
    }
    public function imprimante(){
        return $this->belongsTo(Imprimante::class, 'imprimante_id', 'id_imprimante');
    }

    public function devisLivres(){
        return $this->hasMany(DevisLivre::class, 'papier_id', 'id_papier');
    }
}
