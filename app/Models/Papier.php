<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papier extends Model
{
    use HasFactory;
    protected $table = 'papiers';
    protected $connection = 'tenant';

    protected $fillable = [
        'categorie',
        'accessoir',
    ];

    public  function categorie(){
        return $this->belongsTo(Categorie::class, 'categorie', 'id_categorie' );
    }
    public function accessoir(){
        return $this->belongsTo(Accessoir::class, 'accessoir', 'id_accessoir');
    }
    public function couleur(){
        return $this->belongsTo(Couleur::class, 'couleur', 'id_couleur');
    }
    public function printer(){
        return $this->belongsTo(Printer::class, 'printer', 'id_printer');
    }
}
