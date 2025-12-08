<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecoupeCatalogue extends Model
{
    use HasFactory;
    protected $connection='tenant';
    protected $table= "decoupe_catalogue";

    protected $fillable = [
        'catalogue_type_id',
        'decoupe',
        'prix',
    ];

    public function catalogueType() {
        return $this->belongsTo( CatalogueType::class, 'catalogue_type_id', 'id');
    }
}
