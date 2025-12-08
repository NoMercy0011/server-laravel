<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmplacementCatalogue extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'emplacement_catalogue';
    protected $fillable = [
        'catalogue_type_id',
        'emplacement',
    ];

    public function catalogueType() {
        return $this->belongsTo( CatalogueType::class, 'catalogue_type_id');
    }
}
