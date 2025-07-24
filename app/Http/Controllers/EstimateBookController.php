<?php

namespace App\Http\Controllers;

use App\Events\DevisLivreCreate;
use App\Models\Accessoir;
use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Couverture;
use App\Models\DevisLivre;
use App\Models\Dimension;
use App\Models\Finition;
use App\Models\Livre;
use App\Models\Papier;
use App\Models\RectoVerso;
use App\Models\Reliure;
use App\Models\StockPapier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstimateBookController extends Controller
{
    public function livre() {
        $livre = Livre::all()->map(function($item){
            return [
                'id_livre' => $item->id_livre ?? null,
                'livre' => $item->livre ?? null,
                'img' => $item->img ?? null,
            ];
        });

        $dimenssion = Dimension::all()->map(function($item){
            return [
                'id_dimension' => $item->id_dimension ?? null,
                'dimension' => $item->dimension ?? null,
                'unitée' => $item->unitée ?? null,
            ];
        });

        $papiers = Papier::with([
                'stockPapier.categorie',
                'stockPapier.accessoire',
                'couleur',
                'imprimante',
            ])->get()
            ->map(function ($item){
                return [
                    'id_papier' => $item->id_papier ?? null,
                    'categorie' => [
                        'id_categorie' => $item->stockPapier?->categorie?->id_categorie ?? null,
                        'categorie' => $item->stockPapier?->categorie?->categorie ?? null,
                    ],
                    'accessoire' => [
                        'id_accessoire' => $item->stockPapier->accessoire->id_accessoire ?? null,
                        'accessoire' => $item->stockPapier->accessoire->accessoire ?? null,
                    ],
                    'couleur' => [
                        'id_couleur' => $item->couleur->id_couleur ?? null,
                        'couleur' => $item->couleur->couleur ?? null,
                    ],
                    'imprimante' => [
                        'id_imprimante' => $item->imprimante->id_imprimante ?? null,
                        'imprimante' => $item->imprimante->imprimante ?? null,
                    ],
                    'prix' => $item->prix ?? null,
                ];
            });

            $couleurs = Couleur::all()->map(function ($item){
                return [
                    'id_couleur' => $item->id_couleur ?? null,
                    'couleur' => $item->couleur ?? null
                ];  
            });

        $recto = RectoVerso::all()->map(function ($item){
            return [
                'id_recto' => $item->id_recto ?? null,
                'type' => $item->type ?? null,
            ];
        });

        $couverture = Couverture::with(['categorie', 'accessoire', 'imprimante'])->get()->map(function($item){
            return [
                'id_couverture' => $item->id_couverture ?? null,
                'categorie' => [
                    'id_categorie' => $item->categorie?->id_categorie ?? null,
                    'categorie' => $item->categorie?->categorie ?? null,
                ],
                'accessoire' => [
                    'id_accessoire' => $item->accessoire?->id_accessoire ?? null,
                    'accessoire' => $item->accessoire?->accessoire ?? null,
                ],
                'imprimante' => [
                    'id_imprimante' => $item->imprimante?->id_imprimante ?? null,
                    'imprimante' => $item->imprimante?->imprimante ?? null,
                ],
                'prix' => $item->prix ?? null,
            ];
        });

        $reliure = Reliure::with([
            'stockReliure',
            'papier',
        ])->get()
        ->map(function ($item){
            return [
                'id_reliure' => $item->id_reliure ?? null,
                'reference' =>  $item /*.' ' .$item*/,
                'min' => $item->min ?? null,
                'max' => $item->max ?? null,
                'papier' => $item->papier->accessoire ?? null,
                'prix' => $item->prix ?? null,

            ];
        });

        $finition = Finition::all()->map(function ($item){
            return [
                'id_finition' => $item->id_finition,
                'finition' => $item->finition,
                'prix' => $item->prix,
            ];
        });

        return response()->json([
            'status' => 200,
            'livre' => [
                'livres' => $livre,
                'dimensions' => $dimenssion,
                'papiers' => $papiers,
                'couleurs' => $couleurs,
                'recto-verso' => $recto,
                'couvertures' => $couverture,
                'reliure' => $reliure,
                'finition' => $finition,
            ],
        ]);
    }

    public function devisLivre(Request $request){

        $validator = Validator::make($request->all(), [
            'type'=> 'required|int',
            'dimension' => 'required|int',
            'papier' => 'required|int',
            'couleur'=> 'required|int',
            'recto_verso'=> 'required|int',
            'pages'=> 'required|int',
            'couverture'=> 'required|int',
            'reliure'=> 'required|int',
            'quantite'=> 'required|int',
        ]);

        if($validator->fails()){
            $error = $validator->errors();
            return response()->json([
                'message' => "Un erreur s'est produit",
                'errors' => $error,
                'status' => 401,
            ],401);
        }

        if($validator->passes()){

            $personnel = $request->user();

            $estimate = DevisLivre::create([
                'livre_id'=> $request->type ?? null,
                'dimension_id'=> $request->dimension ?? null,
                'papier_id' => $request->papier ?? null,
                'couleur_id'=> $request->couleur ?? null,
                'recto_verso_id'=> $request->recto_verso ?? null,
                'pages'=> $request->pages ?? null,
                'couverture_id'=> $request->couverture ?? null,
                'reliure_id'=> $request->reliure ?? null,
                'finition_id'=> $request->finition ?? null,
                'quantite'=> $request->quantite ?? null,
                'montant'=> $request->montant ?? null,
                'client_id'=> $request->client ?? null,
                'personnel'=> $personnel->id ?? null,

            ]);

            event(new DevisLivreCreate($estimate, $personnel));
            return response()->json([
                'status' => 201,
                'message' => 'devis ajoutée avec succèss',
            ]);
        }
    }

    public function getDevisLivre(){
        $devis = DevisLivre::with([
            'livre', 
            'dimension', 
            'papier.stockPapier.categorie', 
            'papier.stockPapier.accessoire', 
            'couleur',
            'recto_verso',
            'couverture.stockPapier',
            'reliure.stockReliure', 
            'finition', 
            'personnel',
            'client'
        ])->get();


        $data = $devis->map(function ($item){
            return[
            'id_devis' => $item->id_devis,
            'livre' => [
                'type' => $item->livre->livre ?? null, 
                'img' => $item->livre->img ?? null,
            ] ?? null , 
            'dimension' =>[
                'dimension' =>$item->dimension->dimension ?? null,
                'unitée' =>$item->dimension->unitée ?? null,
            ] ?? null , 
            'papier' => $item->papier->stockPapier?->categorie?->categorie. ' - ' . $item->papier->stockPapier?->accessoire?->accessoire,
            'couleur' => $item->couleur->couleur,
            'recto_verso' => $item->recto_verso->type,
            'couverture' => $item->couverture->stockPapier?->categorie?->categorie. ' - ' . $item->couverture->stockPapier?->accessoire?->accessoire,
            'reliure' => [
                'reliure' => $item->reliure->reference->reliure ?? null,
                'reference' => $item->reliure->reference->reference ?? null,
            ], 
            'finition' => $item->finition->finition ?? null, 
            'client' => [
                'nom' => $item->client->nom,
                'prenom' => $item->client->prenom,
            ],
            'personnel' => [
                'nom' => $item->personnel->nom,
                'pseudo' => $item->personnel->pseudo,
            ], 
            ];
        });
        
        return response()->json([
            'status' => 200,
            'devis' => $data,
        ]);
    }
}
