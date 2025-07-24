<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $connection = 'tenant';
    protected $primaryKey ='id_client';
    protected $table = 'client';
    protected $fillable = [
        'nom',
        'prenom',
        'contact',
        'adresse',
    ];

    public function devisLivreClients(){
        return $this->hasMany(DevisLivre::class, 'client_id', 'id_client');
    }
}
