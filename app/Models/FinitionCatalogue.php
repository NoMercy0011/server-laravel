<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinitionCatalogue extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'finition_catalogue';
    protected $fillable = [
        'catalogue_type_id',
        'finition',
    ];

    public function catalogueType() {
        return $this->belongsTo( CatalogueType::class,'catalogue_type_id','id');
    }
}
