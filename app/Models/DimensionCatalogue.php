<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimensionCatalogue extends Model
{
    use HasFactory;

    protected $connection ="tenant";
    protected $table = "dimension_catalogue";
    protected $fillable = [
        "catalogue_type_id",
        "dimension"
    ];


    public function catalogueType(){
        return $this->belongsTo( CatalogueType::class, "catalogue_type_id", 'id');
    }
}
