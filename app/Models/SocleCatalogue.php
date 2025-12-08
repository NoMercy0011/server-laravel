<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocleCatalogue extends Model
{
    use HasFactory;
    protected $connection = "tenant";
    protected $table = "socle_catalogue";
    protected $fillable = [
        "catalogue_type_id",
        "socle",
        "inventaire_id",
    ];

    public function catalogueType(){
        return $this->belongsTo(CatalogueType::class, "catalogue_type_id");
    }
}
