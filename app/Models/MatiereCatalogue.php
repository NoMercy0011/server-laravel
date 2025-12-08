<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatiereCatalogue extends Model
{
    use HasFactory;
    protected $connection= "tenant";

    protected $table= "matiere_catalogue";

    protected $fillable = [
        "catalogue_type_id",
        'inventaire_id'
    ];

    public function catalogueType() {
        return $this->belongsTo( CatalogueType::class, 'catalogue_type_id');
    }

    public function inventaire() {
        return $this->belongsTo( Inventaire::class, 'inventaire_id');
    }
}
