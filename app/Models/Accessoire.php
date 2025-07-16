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

    public function papiers(){
        return $this->hasMany(Papier::class, 'accessoire_id', 'id_accessoire');
    }

    public function couvertures(){
        return $this->hasMany(Couverture::class, 'accessoire_id', 'id_accessoire');
    }
}
