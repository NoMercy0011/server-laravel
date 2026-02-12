<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogueType extends Model
{
    use HasFactory;

    protected $connection = "tenant";
    protected $table= "catalogue_type";
    protected $fillable = [
        'catalogue_id',
        'code',
        'type',
    ];

    public function catalogue() {
       return $this->belongsTo(Catalogue::class,'catalogue_id','id');
    }

    public function dimensions(){
        return $this->hasMany(DimensionCatalogue::class,'catalogue_type_id','id')->orderBy('dimension');
    }

    public function matieres() {
        return $this->hasMany( MatiereCatalogue::class, 'catalogue_type_id');
    }
    public function couleurs() {
        return $this->hasMany(CouleurCatalogue::class,'catalogue_type_id','id');
    }

    public function emplacements(){
        return $this->hasMany( EmplacementCatalogue::class, 'catalogue_type_id');
    }

    public function finitions() {
        return $this->hasMany( FinitionCatalogue::class,'catalogue_type_id','id');
    }

    public function imprimantes() {
        return $this->hasMany( ImprimanteCatalogue::class,'catalogue_type_id','id');
    }

    public function particularites() {
        return $this->hasMany( ParticulariteCatalogue::class, 'catalogue_type_id', 'id');
    }

    public function decoupes() {
        return $this->hasMany( DecoupeCatalogue::class, 'catalogue_type_id', 'id');
    }

    public function socles() {
        return $this->hasMany( SocleCatalogue::class, 'catalogue_type_id', 'id');
    }
    public function coutures() {
        return $this->hasMany( CoutureCatalogue::class, 'catalogue_type_id', 'id');
    }
    public function epaisseurs() {
        return $this->hasMany( EpaisseurCatalogue::class, 'catalogue_type_id', 'id');
    }
}
