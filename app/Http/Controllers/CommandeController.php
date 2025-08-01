<?php

namespace App\Http\Controllers;

use App\Events\CommandeCreate;
use App\Models\Commande;
use App\Models\DevisLivre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommandeController extends Controller
{
    public function create(Request $request){
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'commande'=> 'required|string',
            'devis_cible' => 'required|string',
            'devis_id' => 'required|int',
            'prix' => 'required|string',
            'personnel_id'=> 'required|int',
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

            $commande = Commande::create([
                'commande'=> $request->commande ?? null,
                'devis_cible'=> $request->devis_cible ?? null,
                'devis_id' => $request->devis_id ?? null,
                'prix' => $request->prix ?? null,
                'personnel_id'=> $request->personnel_id ?? null,
            ]);
        $signature = $request->devis_cible ?? null;
        event(new CommandeCreate($commande, $personnel));
        return response()->json([
            'message' => 'Nouvelle commande ajouté',
            'type' => $signature,

        ]);
    }
}
    public function get() {
        
        $commandes = Commande::all()->map( function ($item) {
            // $devis = DevisLivre
            return [
                'data' => $item,
            ];
        });

        return response()->json([
            'commandes' => $commandes
        ]);
    }
}
