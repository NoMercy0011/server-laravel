<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_document';
    protected $connection = 'tenant';
    protected $table = 'documents';
    protected $fillable = [
        'client_id',
        'numero_document',
        'type_document',
        'date_emission',
        'date_echeance',
        'sous_total_ht',
        'remise',
        'montant_tax',
        'total_ttc',
        'status',
    ];

    public function client() {
       return $this->belongsTo( Client::class, 'client_id', 'id_client'); 
    }
    public function ligneDocuments(){
        return $this->hasMany(LigneDocument::class, 'document_id', 'id_document');
    }
    public function devisLivreDocuments(){
        return $this->hasMany(DevisLivre::class, 'document_id', 'id_document');
    }
}
