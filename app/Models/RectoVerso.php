<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RectoVerso extends Model
{
    use HasFactory;

    protected $connection = 'tenant';
    protected $primaryKey = 'id_recto';

    protected $table = 'recto-verso';

    public function devisLivres(){
        return $this->hasMany(DevisLivre::class, 'recto_verso_id', 'id_recto');
    }
}
