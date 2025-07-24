<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'commandes';
    protected $primaryKey = 'id_commande';
    protected $fillable =[
        'commande',
        'devis_cible',
        'devis_id',
        'personnel_id'
    ];

    public function personnel(){
        return $this->belongsTo(User::class, 'personnel_id', 'id');
    }
}
