<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'tenant';
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id';
     protected $fillable = [
        'nom',
        'pseudo',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function devisLivres(){
        return $this->hasMany(DevisLivre::class, 'user_id', 'id');
    }

    public function mouvementsPapiers(){
        return $this->hasMany(MouvementPapier::class, 'user_id', 'id');
    }

    public function mouvementsReliures(){
        return $this->hasMany(MouvementReliure::class, 'user_id', 'id');
    }
    public function commandesUsers(){
        return $this->hasMany(Commande::class, 'personnel_id', 'id');
    }
}
