<?php

namespace App\Http\Controllers;

use App\Models\Document;
// Assurez-vous d'importer vos modèles
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class DocumentController extends Controller
{
    /**
     * Constante pour le taux de TVA (ex: 20%)
     */
    const TVA_RATE = 0.20;

    /**
     * Enregistre un nouveau document et ses lignes à partir d'un panier.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // --- 1. VALIDATION DES DONNÉES ENTRANTES ---
        $validator = Validator::make($request->all(), [
            // On attend un tableau 'cartItems' qui ne doit pas être vide
            'cartItems' => 'required|array|min:1',
            // On valide chaque objet dans le tableau
            'cartItems.*.id' => 'required|integer', // Supposant que c'est l'ID du produit/service
            'cartItems.*.designation' => 'required|string|max:255',
            'cartItems.*.quantite' => 'required|numeric|min:0',
            'cartItems.*.prixUnitaire' => 'required|numeric|min:0',
            'cartItems.*.remise' => 'required|numeric|min:0',
            // Ajoutez ici d'autres validations si nécessaire
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $cartItems = $request->input('cartItems');

        // --- 2. CALCUL DES TOTAUX POUR LE DOCUMENT PRINCIPAL ---
        $sousTotalHt = 0;
        $montantTotalRemise = 0;

        foreach ($cartItems as $item) {
            $sousTotalHt += $item['quantite'] * $item['prixUnitaire'];
            $montantTotalRemise += $item['remise'];
        }

        $baseTaxable = $sousTotalHt - $montantTotalRemise;
        $montantTaxe = $baseTaxable * self::TVA_RATE;
        $totalTtc = $baseTaxable + $montantTaxe;
        
        // --- 3. TRANSACTION DE BASE DE DONNÉES ---
        try {
            $nouveauDocument = DB::transaction(function () use ($cartItems, $sousTotalHt, $montantTotalRemise, $montantTaxe, $totalTtc) {
                
                // --- 4. CRÉATION DU DOCUMENT ---
                // Remplacez les valeurs statiques par vos données réelles (ex: client_id depuis l'utilisateur authentifié)
                $document = Document::create([
                    'client_id' => auth()->id() ?? 1, // Exemple: ID de l'utilisateur connecté ou un client par défaut
                    'numero_document' => 'FA-' . now()->format('Ymd-His'), // Génération d'un numéro unique
                    'type_document' => 'facture', // Ou 'proforma', à adapter selon la logique
                    'date_emission' => now(),
                    'sous_total_ht' => $sousTotalHt,
                    'montant_remise' => $montantTotalRemise,
                    'montant_taxe' => $montantTaxe,
                    'total_ttc' => $totalTtc,
                    'statut' => 'brouillon',
                ]);

                // --- 5. CRÉATION DES LIGNES DU DOCUMENT ---
                foreach ($cartItems as $item) {
                    // On utilise la relation définie dans le modèle Document pour créer la ligne.
                    // Laravel s'occupe automatiquement de lier avec le bon document_id.
                    $document->lignes()->create([
                        'produit_service_id' => $item['id'],
                        'designation' => $item['designation'], // On copie la désignation
                        'quantite' => $item['quantite'],
                        'prix_unitaire_ht' => $item['prixUnitaire'], // On copie le prix
                        // On calcule le total de la ligne
                        'prix_total_ht' => $item['quantite'] * $item['prixUnitaire'], 
                    ]);
                }
                
                return $document;
            });
            
            // --- 6. RÉPONSE DE SUCCÈS ---
            // On recharge la relation pour l'inclure dans la réponse JSON
            $nouveauDocument->load('lignes'); 

            return response()->json([
                'message' => 'Document créé avec succès !',
                'document' => $nouveauDocument
            ], 201);

        } catch (Throwable $e) {
            // En cas d'erreur, la transaction est automatiquement annulée (rollback).
            // On logue l'erreur pour le débogage.
            report($e);

            // Et on retourne une réponse d'erreur générique au client.
            return response()->json([
                'message' => 'Une erreur est survenue lors de la création du document.'
            ], 500);
        }
    }
}