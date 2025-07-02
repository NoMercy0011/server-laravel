<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couverture extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'couvertures';

    public  function categorie(){
        return $this->belongsTo(Categorie::class, 'couverture', 'id_categorie' );
    }
    public function accessoir(){
        return $this->belongsTo(Accessoir::class, 'accessoire', 'id_accessoir');
    }
    public function printer(){
        return $this->belongsTo(Printer::class, 'printer_id', 'id_printer');
    }
}
