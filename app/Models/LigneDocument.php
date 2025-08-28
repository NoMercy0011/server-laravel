<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneDocument extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_ligne_document';
    protected $connection = 'tenant';
    protected $table = 'ligne_document';
    protected $fillable = [
        'document_id',
        'service',
        'designation',
        'detail_description',
        'quantite',
        'prix_unitaire_ht',
        'remise',
    ];

    public function document() {
       return $this->belongsTo( Document::class, 'document_id', 'id_document'); 
    }
}
