<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockPapier extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'stock_papier';

    protected $fillalble = [
        'categorie_id',
        'accessoire_id',
        'stock',
        'seuil',
    ];

    public function couvertures(){
        return $this->hasMany(Couverture::class, 'stock_papier_id', 'id_stock_papier');
    }

    public function papiers(){
        return $this->hasMany(Papier::class, 'stock_papier_id', 'id_stock_papier');
    }

    public function mouvementsPapiers(){
        return $this->hasMany(MouvementPapier::class, 'stock_papier_id', 'id_stock_papier');
    }

    public function categorie(){
        return $this->belongsTo(Categorie::class, 'categorie_id', 'id_categorie');
    }

    public function accessoire(){
        return $this->belongsTo(Accessoire::class, 'accessoire_id', 'id_accessoire');
    }

}
