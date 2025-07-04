<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    use HasFactory;
     protected $connection = 'tenant';
    protected $primaryKey = 'id_dimension';


    protected $fillable = [
        'dimension',
        'unitée',
    ];

    public function devisLivres(){
        return $this->hasMany(DevisLivre::class, 'dimension', 'id_dimension');
    }
}
