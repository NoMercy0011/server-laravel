<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\PersonalAccessToken;

class TenantAccessToken extends PersonalAccessToken
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'personal_access_tokens';
}
