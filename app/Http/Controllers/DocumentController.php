<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class DocumentController extends Controller
{
    public function createFacture(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'document' => 'required|array',
            'ligne_document' => 'required|array|min:1',
            'devis_livre' => 'required|array|min:1',
            'document.client_id' => 'required|integer',
            'document.total_ttc' => 'required'
        ]);

        if( $validator->fails()){
            return response()->json([
                'erreur' => $validator->errors()->first(), 
                'message' => $validator->errors()->first(), 
            ], 422);
        }

        $documentData = $request->document;
        $lignesData = $request->ligne_document;
        $devisLivre = $request->devis_livre;

        $user = $request->user();
        

        try {
            $nouveauDocument = DB::transaction( function () use($documentData, $lignesData, $devisLivre, $user){
                $dateEmission = now();
                $dateEcheance = $dateEmission->copy()->addMonths(3);
                
                $documentData['date_emission'] = $dateEmission;
                $documentData['date_echeance'] = $dateEcheance;
                $documentData['numero_document'] = 'FA-' . now()->format('Ymd-His');

                $documentCreated = Document::create($documentData);
                $documentCreated->ligneDocuments()->createMany($lignesData);

                foreach ($devisLivre as $item) {
                    $item['user_id'] = $user->id;
                    $documentCreated->devisLivreDocuments()->create($item);
                }


                return $documentCreated;
            });
            $nouveauDocument->load('ligneDocuments', 'devisLivreDocuments');

            return response()->json([
            "message" => "Création de votre document réussie",
            'nouveau document' => $nouveauDocument,
        ]);
        } catch( Throwable $e) { //Throwable
            report($e);
            return response()->json([
                'message' => "Erreur lors de la création du Facture",
                "erreur" => $e
            ]);
        }
        
    }

    public function createProforma(Request $request) {
        $validator = Validator::make($request->all(), [
            'document' => 'required|array',
            'ligne_document' => 'required|array|min:1',
            'devis_livre' => 'required|array|min:1',
            'document.client_id' => 'required|integer',
            'document.total_ttc' => 'required'
        ]);

        if( $validator->fails()){
            return response()->json([
                'erreur' => $validator->errors()->first(), 
                'message' => $validator->errors()->first(), 
            ], 422);
        }

        $documentData = $request->document;
        $lignesData = $request->ligne_document;
        $devisLivre = $request->devis_livre;

        $user = $request->user();
        

        try {
            $nouveauDocument = DB::transaction( function () use($documentData, $lignesData, $devisLivre, $user){
                $dateEmission = now();
                $dateEcheance = $dateEmission->copy()->addMonths(3);
                
                $documentData['date_emission'] = $dateEmission;
                $documentData['date_echeance'] = $dateEcheance;
                $documentData['numero_document'] = 'PRO-' . now()->format('Ymd-His');

                $documentCreated = Document::create($documentData);
                $documentCreated->ligneDocuments()->createMany($lignesData);

                foreach ($devisLivre as $item) {
                    $item['user_id'] = $user->id;
                    $documentCreated->devisLivreDocuments()->create($item);
                }


                return $documentCreated;
            });
            $nouveauDocument->load('ligneDocuments', 'devisLivreDocuments');

            return response()->json([
            "message" => "Création de votre document réussie",
            'nouveau document' => $nouveauDocument,
        ]);
        } catch( Throwable $e) { //Throwable
            report($e);
            return response()->json([
                'message' => "Erreur lors de la création du Facture",
                "erreur" => $e
            ]);
        }
        
    }

    public function getDocument() {
        
        $factures = Document::with([
            'client',
            'ligneDocuments',
        ])->where('type_document', 'facture')->get()->map( function ($document) {
            return [
                //'data' => $document,
                'document' => [
                    'id_document' => $document->id_document ?? null,
                    'client_id' => $document->client_id ?? null,
                    'numero_document' => $document->numero_document ?? null,
                    'type_document' => $document->type_document ?? null,
                    'date_emission' => $document->date_emission ?? null,
                    'date_echeance' => $document->date_echeance ?? null,
                    'sous_total_ht' => $document->sous_total_ht ?? null, 
                    'remise' => $document->remise ?? null, 
                    'montant_tax' => $document->montant_tax ?? null, 
                    'total_ttc' => $document->total_ttc ?? null, 
                    'status' => $document->status ?? null, 
                ],

                'client' => [
                    'id_client' => $document->client->id_client ?? null, 
                    'nom_societe' => $document->client->nom_societe ?? null, 
                    'nom_contact' => $document->client->nom_contact ?? null, 
                    'media_social' => $document->client->media_social ?? null, 
                ],

                'ligne_document' => $document->ligneDocuments->map(function ($ligne) {
                    return [
                        'id' => $ligne->id_ligne_document ?? null,
                        'service' => $ligne->service ?? null,
                        'designation' => $ligne->designation ?? null,
                        'detail_description' => $ligne->detail_description ?? null,
                        'quantite' => $ligne->quantite ?? null,
                        'prix_unitaire_ht' => $ligne->prix_unitaire_ht ?? null,
                        'remise' => $ligne->remise ?? null,
                    ];
                })


            ];
        });

        $proformas = Document::with([
            'client',
            'ligneDocuments',
        ])->where('type_document', 'proforma')->get()->map( function ($document) {
            return [
                //'data' => $document,
                'document' => [
                    'id_document' => $document->id_document ?? null,
                    'client_id' => $document->client_id ?? null,
                    'numero_document' => $document->numero_document ?? null,
                    'type_document' => $document->type_document ?? null,
                    'date_emission' => $document->date_emission ?? null,
                    'date_echeance' => $document->date_echeance ?? null,
                    'sous_total_ht' => $document->sous_total_ht ?? null, 
                    'remise' => $document->remise ?? null, 
                    'montant_tax' => $document->montant_tax ?? null, 
                    'total_ttc' => $document->total_ttc ?? null, 
                    'status' => $document->status ?? null, 
                ],
                'client' => [
                    'id_client' => $document->client->id_client ?? null, 
                    'nom_societe' => $document->client->nom_societe ?? null, 
                    'nom_contact' => $document->client->nom_contact ?? null, 
                    'media_social' => $document->client->media_social ?? null, 
                ],

                'ligne_document' => $document->ligneDocuments->map(function ($ligne) {
                    return [
                        'id' => $ligne->id_ligne_document ?? null,
                        'service' => $ligne->service ?? null,
                        'designation' => $ligne->designation ?? null,
                        'detail_description' => $ligne->detail_description ?? null,
                        'quantite' => $ligne->quantite ?? null,
                        'prix_unitaire_ht' => $ligne->prix_unitaire_ht ?? null,
                        'remise' => $ligne->remise ?? null,
                    ];
                })


            ];
        });


        return response()->json([
            "factures" => $factures,  
            "proformas" => $proformas
        ]);
    }
}
