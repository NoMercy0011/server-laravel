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

    public  function stockPapier(){
        return $this->belongsTo(StockPapier::class, 'stock_papier_id', 'id_stock_papier');
    }
    public function imprimante(){
        return $this->belongsTo(Imprimante::class, 'imprimante_id', 'id_imprimante');
    }
    public function devisLivres(){
        return $this->hasMany(DevisLivre::class, 'couverture_id', 'id_couverture');
    }
}
