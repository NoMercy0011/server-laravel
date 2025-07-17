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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstimateBookController extends Controller
{
    public function livre() {
        $livre = Livre::all()->map(function($item){
            return [
                'id_livre' => $item->id_livre,
                'livre' => $item->livre,
                'img' => $item->img,
            ];
        });

        $dimenssion = Dimension::all()->map(function($item){
            return [
                'id_dimension' => $item->id_dimension,
                'dimension' => $item->dimension,
                'unitée' => $item->unitée,
            ];
        });

        $papiers = Papier::with([
                'categorie',
                'accessoire',
                'couleur',
                'imprimante',
            ])->get()
            ->map(function ($item){
                return [
                    'id_papier' => $item->id_papier,
                    'categorie' => [
                        'id_categorie' => $item->categorie->id_categorie,
                        'categorie' => $item->categorie->categorie,
                    ],
                    'accessoire' => [
                        'id_accessoire' => $item->accessoire->id_accessoire,
                        'accessoire' => $item->accessoire->accessoire,
                    ],
                    'couleur' => [
                        'id_couleur' => $item->couleur->id_couleur,
                        'couleur' => $item->couleur->couleur,
                    ],
                    'imprimante' => [
                        'id_imprimante' => $item->imprimante->id_imprimante,
                        'imprimante' => $item->imprimante->imprimante,
                    ],
                    'prix' => $item->prix,
                ];
            });

            $couleurs = Couleur::all()->map(function ($item){
                return [
                    'id_couleur' => $item->id_couleur,
                    'couleur' => $item->couleur
                ];  
            });

        $recto = RectoVerso::all()->map(function ($item){
            return [
                'id_recto' => $item->id_recto,
                'type' => $item->type,
            ];
        });

        $couverture = Couverture::with(['categorie', 'accessoire', 'imprimante'])->get()->map(function($item){
            return [
                'id_couverture' => $item->id_couverture,
                'categorie' => [
                    'id_categorie' => $item->categorie?->id_categorie,
                    'categorie' => $item->categorie?->categorie,
                ],
                'accessoire' => [
                    'id_accessoire' => $item->accessoire?->id_accessoire,
                    'accessoire' => $item->accessoire?->accessoire,
                ],
                'imprimante' => [
                    'id_imprimante' => $item->imprimante?->id_imprimante,
                    'imprimante' => $item->imprimante?->imprimante,
                ],
                'prix' => $item->prix,
            ];
        });

        $reliure = Reliure::with([
            'reference',
            'papier',
        ])->get()
        ->map(function ($item){
            return [
                'id_reliure' => $item->id_reliure,
                'reference' =>  $item->reference->reliure .' ' .$item->reference->reference,
                'min' => $item->min,
                'max' => $item->max,
                'papier' => $item->papier->accessoire,
                'prix' => $item->prix,

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
                'livre'=> $request->type,
                'dimension'=> $request->dimension,
                'papier' => $request->papier,
                'couleur'=> $request->couleur,
                'recto_verso'=> $request->recto_verso,
                'pages'=> $request->pages,
                'couverture'=> $request->couverture,
                'reliure'=> $request->reliure,
                'finition'=> $request->finition,
                'quantite'=> $request->quantite,
                'montant'=> $request->montant,
                'personnel'=> $personnel->id,

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
            'papier.categorie', 
            'papier.accessoire', 
            'couleur',
            'recto_verso',
            'couverture.categorie', 
            'couverture.accessoire', 
            'reliure.reference', 
            'finition', 
            'personnel',
        ])->get();


        $data = $devis->map(function ($item){
            return[
            'id_devis' => $item->id_devis,
            'livre' => $item->livre->livre, 
            'dimension' =>[
                'dimension' =>$item->dimension->dimension ?? null,
                'unitée' =>$item->dimension->unitée ?? null,
            ] ?? null , 
            'papier' => [
                'categorie' => $item->papier->categorie->categorie ?? null,
                'accessoire' => $item->papier->accessoire->accessoire ?? null,
            ] ?? null, 
            'couleur' => $item->couleur->couleur,
            'recto_verso' => $item->recto_verso->type,
            'couverture' => [
                'categorie' => $item->couverture->categorie->categorie ?? null,
                'accessoire' => $item->couverture->accessoire->accessoire ?? null,
            ], 
            'reliure' => [
                'reliure' => $item->reliure->reference->reliure ?? null,
                'reference' => $item->reliure->reference->reference ?? null,
            ], 
            'finition' => $item->finition->finition ?? null, 
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
