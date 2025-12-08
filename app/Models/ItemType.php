<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;
    protected $connection = "tenant";
    protected $table = "item_type";

    protected $fillable = [
        'type',
        'description',
    ];

    public function inventaires(){
        return $this->hasMany( Inventaire::class,'item_type_id','id');
    }
}
