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
        'livre_id',
        'dimension_id',
        'papier_id',
        'couleur_id',
        'recto_verso_id',
        'pages',
        'couverture_id',
        'reliure_id',
        'finition_id',
        'quantite',
        'montant',
        'client_id',
        'user_id',
        'status',
    ];

    public  function livre(){
        return $this->belongsTo(Livre::class, 'livre_id', 'id_livre' );
    }
    public  function dimension(){
        return $this->belongsTo(Dimension::class, 'dimension_id', 'id_dimension' );
    }
    public  function papier(){
        return $this->belongsTo(Papier::class, 'papier_id', 'id_papier' );
    }
    public function couleur(){
        return $this->belongsTo(Couleur::class, 'couleur_id', 'id_couleur');
    }
    public function recto_verso(){
        return $this->belongsTo(RectoVerso::class, 'recto_verso_id', 'id_recto');
    }

    public function couverture(){
        return $this->belongsTo(Couverture::class, 'couverture_id', 'id_couverture');
    }

    public function reliure(){
        return $this->belongsTo(Reliure::class, 'reliure_id', 'id_reliure');
    }

    public function finition(){
        return $this->belongsTo(Finition::class, 'finition_id', 'id_finition');
    }

    public function personnel(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'client_id', 'id_client');
    }

    public function mouvementPapiers(){
        return $this->hasMany(MouvementPapier::class, 'devis_livre_id', 'id_devis');
    }

    public function mouvementReliures(){
        return $this->hasMany(MouvementReliure::class, 'devis_livre_id', 'id_devis');
    }

    public function calculMontant() {
        $total = 0;

        return $total;
    }
}
