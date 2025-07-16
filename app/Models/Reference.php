<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'reference';

    protected $fillable = [
        'reliure',
        'reference',
    ];

    public function reliures(){
        return $this->hasMany(Reliure::class, 'reference_id', 'id_reference');
    }
}
