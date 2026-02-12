<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpaisseurCatalogue extends Model
{
    use HasFactory;

    protected $connection = 'tenant';
    protected $table = 'epaisseur_catalogue';
    protected $fillable = [
        'catalogue_type_id',
        'epaisseur',
    ];

    public function catalogueType() {
        return $this->belongsTo( CatalogueType::class,'catalogue_type_id','id');
    }
}
