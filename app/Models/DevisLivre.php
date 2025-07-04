<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisLivre extends Model
{
    use HasFactory;

    protected $connection = 'tenant';
    protected $primaryKey = 'id_devis';

    protected $table = 'devis_livre';

    protected $fillable = [
        'livre',
        'dimension',
        'papier',
        'couleur',
        'recto_verso',
        'pages',
        'couverture',
        'reliure',
        'finition',
        'quantite',
        'montant',
        'personnel',
        'status',
    ];

    public  function livre(){
        return $this->belongsTo(Livre::class, 'livre', 'id_livre' );
    }
    public  function dimension(){
        return $this->belongsTo(Dimension::class, 'dimension', 'id_dimension' );
    }
    public  function papier(){
        return $this->belongsTo(Papier::class, 'papier', 'id_papier' );
    }
    public function couleur(){
        return $this->belongsTo(Couleur::class, 'couleur', 'id_couleur');
    }
    public function recto_verso(){
        return $this->belongsTo(RectoVerso::class, 'recto_verso', 'id_recto');
    }

    public function couverture(){
        return $this->belongsTo(Couverture::class, 'couverture', 'id_couverture');
    }

    public function reliure(){
        return $this->belongsTo(Reliure::class, 'reliure', 'id_reliure');
    }

    public function finition(){
        return $this->belongsTo(Finition::class, 'finition', 'id_finition');
    }

    public function calculMontant() {
        $total = 0;

        return $total;
    }
}
