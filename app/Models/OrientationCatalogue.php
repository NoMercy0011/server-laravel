<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrientationCatalogue extends Model
{
    use HasFactory;
    protected $connection = "tenant";
    protected $table = "orientation_catalogue";
    protected $fillable = [
        "orientation",
    ];

}
