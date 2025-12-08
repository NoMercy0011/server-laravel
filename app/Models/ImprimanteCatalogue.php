<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImprimanteCatalogue extends Model
{
    use HasFactory;
    protected $connetion= 'tenant';
    protected $table = 'imprimante_catalogue';
    protected $fillable = [
        'catalogue_type_id',
        'imprimante'
    ];

    public function catalogueType() {
        return $this->belongsTo( CatalogueType::class, 'catalogue_type_id');
    }
}
