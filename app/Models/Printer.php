<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'printers';

    public function papiers(){
        return $this->hasMany(Papier::class, 'printer', 'id_printer');
    }

    public function couvertures(){
        return $this->hasMany(Couverture::class, 'printer_id', 'id_printer');
    }
}
