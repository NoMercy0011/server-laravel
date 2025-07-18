<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockReliure extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'stock_reliure';

    protected $fillalble = [
        'reliure',
        'reference',
        'stock',
        'seuil',
    ];

    public function reliures(){
        return $this->hasMany(Reliure::class, 'stock_reliure_id', 'id_stock_reliure');
    }

    public function mouvementsReliures(){
        return $this->hasMany(MouvementReliure::class, 'stock_reliure_id', 'id_stock_reliure');
    }
}
