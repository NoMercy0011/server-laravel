<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementPapier extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'mouvements_papier';

    protected $fillalble = [
        'stock_papier_id',
        'fournisseur_id',
        'type',
        'quantite',
        'motif',
        'prix_achat',
        'user_id',
    ];

    public function stockPapier(){
        return $this->belongsTo(StockPapier::class, 'stock_papier_id', 'id_stock_papier');
    }

    public function fournisseur(){
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id', 'id_fournisseur');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function devisLivre(){
        return $this->belongsTo(DevisLivre::class, 'devis_livre_id', 'id_devis');
    }
}
