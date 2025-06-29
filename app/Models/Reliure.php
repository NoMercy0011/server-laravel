<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reliure extends Model
{
    use HasFactory;

    protected $connection = 'tenant';
    protected $table = 'reliures';
}
