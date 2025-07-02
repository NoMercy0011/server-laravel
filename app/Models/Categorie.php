<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
     protected $connection = 'tenant';
    protected $table = 'categories';

    public function papiers(){
        return $this->hasMany(Papier::class, 'categorie', 'id_categorie');
    }

    public function couvertures(){
        return $this->hasMany(Couverture::class, 'couverture', 'id_categorie');
    }
}
