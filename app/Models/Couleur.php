<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couleur extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $primaryKey = 'id_couleur';

    protected $table = 'couleurs';

    public function devisLivres(){
        return $this->hasMany(DevisLivre::class, 'couleur_id', 'id_couleur');
    }
}
