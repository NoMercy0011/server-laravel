<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nom',
        'slug',
        'database',
    ];
    protected $casts = [
        // don't cast 'data' anymore
    ];

    // public static function getCustomColumns(): array
    // {
    //     return [
    //         'id',
    //         'slug',
    //         'database',
    //     ];
    // }
}
