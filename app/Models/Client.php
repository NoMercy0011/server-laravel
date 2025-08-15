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
        'nom_societe',
        'nom_contact',
        'media_social',
        'commercial_id',
        'email',
        'telephone_1',
        'telephone_2',
        'nif',
        'stat',
        'rue',
        'ville',
    ];

    public function devisLivreClients(){
        return $this->hasMany(DevisLivre::class, 'client_id', 'id_client');
    }

    public function commercial() {
        return $this->belongsTo( Commercial::class, 'commercial_id', 'id_commercial');
    }
}
