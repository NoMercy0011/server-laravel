<?php

namespace App\Http\Controllers;

use App\Events\DevisLivreCreate;
use App\Models\Accessoir;
use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Couverture;
use App\Models\DevisLivre;
use App\Models\Dimension;
use App\Models\Livre;
use App\Models\Papier;
use App\Models\Reliure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstimateBookController extends Controller
{
    public function livre() {
        $papiers = Categorie::with(['papiers.accessoire'])->get()->map(function($categorie){
            return [
                'categorie' => $categorie->categorie,
                'accessoire' => $categorie->papiers->filter(fn($p) => $p->accessoire !== null)->values(),
            ];
        });

        $couverture = Couverture::with(['categorie', 'accessoire', 'imprimante'])->get()->map(function($item){
            return [
                'id' => $item->id_couverture,
                'categorie' => $item->categorie?->categorie,
                'accessoire' => $item->accessoire?->accessoire,
                'prix' => $item->prix,
                'imprimante' => $item->imprimante?->imprimante,
            ];
        });


        return response()->json([
            'status' => 200,
            'livre' => [
                'types' => Livre::all(),
                'dimensions' => Dimension::all(),
                'papiers' => $papiers,
                'couleurs' => Couleur::all(),
                'couvertures' => $couverture,
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
}
