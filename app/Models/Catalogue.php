<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;

    protected $connection = "tenant";
    protected $table = "catalogue";
    protected $fillable = [
        'catalogue'
    ];

    public function catalogueTypes() {
        return $this->hasMany(CatalogueType::class, 'catalogue_id', 'id');
    }
}
