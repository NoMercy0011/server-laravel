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

    public function stockPapiers(){
        return $this->hasMany(StockPapier::class, 'categorie_id', 'id_categorie');
    }

}
