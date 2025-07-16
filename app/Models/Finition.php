<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finition extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $primaryKey = 'id_finition';

    protected $table = 'finitions';
    public function devisLivres(){
        return $this->hasMany(DevisLivre::class, 'finition_id', 'id_finition');
    }
}
