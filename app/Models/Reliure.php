<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reliure extends Model
{
    use HasFactory;

    protected $connection = 'tenant';
    protected $primaryKey = 'id_reliure';
    protected $table = 'reliures';

    public function devisLivres(){
        return $this->hasMany(DevisLivre::class, 'reliure_id', 'id_reliure');
    }

    public  function stockReliure(){
        return $this->belongsTo(StockReliure::class, 'stock_reliure_id', 'id_stock_reliure' );
    }
    public  function papier(){
        return $this->belongsTo(Accessoire::class, 'papier_id', 'id_accessoire' );
    }
}
