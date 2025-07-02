<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessoir extends Model
{
    use HasFactory;
     protected $connection = 'tenant';
    protected $table = 'accessoirs';

    public function papiers(){
        return $this->hasMany(Papier::class, 'accessoir', 'id_accessoir');
    }

    public function couvertures(){
        return $this->hasMany(Couverture::class, 'accessoire', 'id_accessoir');
    }
}
