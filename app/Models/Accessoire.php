<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessoire extends Model
{
    use HasFactory;
     protected $connection = 'tenant';
    protected $primaryKey = 'id_accessoire';

    protected $table = 'accessoires';

    public function stockPapiers(){
        return $this->hasMany(StockPapier::class, 'accessoire_id', 'id_accessoire');
    }

}
