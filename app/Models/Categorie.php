<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
     protected $connection = 'tenant';
    protected $primaryKey = 'id_categorie';

    protected $table = 'categories';

    public function papiers(){
        return $this->hasMany(Papier::class, 'categorie_id', 'id_categorie');
    }

    public function couvertures(){
        return $this->hasMany(Couverture::class, 'categorie_id', 'id_categorie');
    }
}
