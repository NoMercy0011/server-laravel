<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imprimante extends Model
{
    use HasFactory;

    protected $connection = 'tenant';
    protected $primaryKey = 'id_imprimante';

    protected $table = 'imprimantes';

    public function papiers(){
        return $this->hasMany(Papier::class, 'imprimante', 'id_imprimante');
    }

    public function couvertures(){
        return $this->hasMany(Couverture::class, 'imprimante_id', 'id_imprimante');
    }
}
