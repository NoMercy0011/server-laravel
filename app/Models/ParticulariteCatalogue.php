<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticulariteCatalogue extends Model
{
    use HasFactory;
    protected $connection = "tenant";
    
    protected $table = "particularite_catalogue";
    
    protected $fillable = [
        'catalogue_type_id',
        'particularite'
    ];

    public function catalogueType() {
        return $this->belongsTo( CatalogueType::class, 'catalogue_type_id', 'id');
    }
}
