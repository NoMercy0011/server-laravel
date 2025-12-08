<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    use HasFactory;

    protected $connection = "tenant";
    protected $table = "inventaire";
    protected $fillable = [
        "item_type_id",
        "type",
        "details",
        "longueur",
        "largeur",
        "caracteristiques",
        "taille",
        "rendement",
        "par",
        "prix_unitaire",
        "unitee"
    ];

    public function matiereCatalogues(){
        return $this->hasMany( MatiereCatalogue::class, 'inventaire_id', 'id');
    }

    public function itemType() {
        return $this->belongsTo( ItemType::class,'item_type_id' , 'id');
    }
}
