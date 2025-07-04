<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couverture extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $primaryKey = 'id_couverture';

    protected $table = 'couvertures';

    public  function categorie(){
        return $this->belongsTo(Categorie::class, 'couverture', 'id_categorie' );
    }
    public function accessoire(){
        return $this->belongsTo(Accessoire::class, 'accessoire_id', 'id_accessoire');
    }
    public function imprimante(){
        return $this->belongsTo(Imprimante::class, 'imprimante_id', 'id_imprimante');
    }
    public function devisLivres(){
        return $this->hasMany(DevisLivre::class, 'couverture', 'id_couverture');
    }
}
