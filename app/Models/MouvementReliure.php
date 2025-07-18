<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementReliure extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'mouvements_reliure';

    protected $fillalble = [
        'stock_reliure_id',
        'fournisseur_id',
        'type',
        'quantite',
        'motif',
        'prix_achat',
        'user_id',
    ];

    public function stockReliure(){
        return $this->belongsTo(StockReliure::class, 'stock_reliure_id', 'id_stock_reliure');
    }

    public function fournisseur(){
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id', 'id_fournisseur');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function devisLivre(){
        return $this->belongsTo(DevisLivre::class, 'devis_livre_id', 'id_devis');
    }
}
