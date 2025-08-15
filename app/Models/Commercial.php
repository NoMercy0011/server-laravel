<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commercial extends Model
{
    use HasFactory;

    protected $connection= 'tenant';
    protected $primaryKey= 'id_commercial';
    protected $table= 'commercial';
    protected $fillable= [
        'nom',
        'prenom',
        'contact',
        'adresse',
    ];

    public function commercialClients() {
        return $this->hasMany(Client::class, 'commercial_id', 'id_commercial');
    }
}
