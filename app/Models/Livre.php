<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;

    protected $connection = 'tenant';
    protected $primaryKey = 'id_livre';

    protected $fillable = [
        'livre',
        'img',
    ];

    public function devisLivres(){
        return $this->hasMany(DevisLivre::class, 'livre', 'id_livre');
    }

}
