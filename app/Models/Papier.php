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
        'stock_papier_id',
        'couleur_id',
        'imprimante_id',
        'prix'
    ];

    public  function stockPapier(){
        return $this->belongsTo(StockPapier::class, 'stock_papier_id', 'id_stock_papier' );
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
    public function reliures(){
        return $this->hasMany(Reliure::class, 'papier_id', 'id_accessoire');
    }
}
