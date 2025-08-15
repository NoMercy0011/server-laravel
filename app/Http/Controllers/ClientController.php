<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'nom_societe'=> 'required|string',
            'nom_contact' => 'required|string',
            //'media_social' => 'required|string',
            'commercial_id'=> 'required|int',
            'email'=> 'required|string',
            /*'nif'=> 'required|string',
            'stat'=> 'required|string',
            'rue'=> 'required|int',
            'ville'=> 'required|int',*/
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

            $client = Client::create([
                'nom_societe'=> $request->nom_societe ?? null,
                'nom_contact'=> $request->nom_contact ?? null,
                'media_social' => $request->media_social ?? null,
                'commercial_id'=> $request->commercial_id ?? null,
                'email'=> $request->email ?? null,
                'nif'=> $request->nif ?? null,
                'stat'=> $request->stat ?? null,
                'rue'=> $request->rue ?? null,
                'ville'=> $request->ville ?? null,
                'telephone_1'=> $request->telephone_1 ?? null,
                'telephone_2'=> $request->telephone_2 ?? null,
            ]);

        return response()->json([
            'message' => "Nouveau client ajouté",
            'status' => 201,
        ], 201);
    }
}
    public function get() {
        $clients = Client::all();
        
        return response()->json([
            'clients' => $clients,
        ]);
    }

    public function getClientID(Request $request) {
        $id = $request->id_client ?? null;
        $client = Client::find($id);
        if(!$client) {
            return response()->json([
                'message' => "client introuvable"
            ]);
        }
        return response()->json([
            'client' => $client,
        ]);
    }
    public function update(Request $request) {
        $id = $request->id_client ?? null;

        $client = Client::find( $id );

        $validator = Validator::make($request->all(), [
            'nom_societe'=> 'required|string',
            'nom_contact' => 'required|string',
            //'media_social' => 'required|string',
            'commercial_id'=> 'required|int',
            'email'=> 'required|string',
            /*'nif'=> 'required|string',
            'stat'=> 'required|string',
            'rue'=> 'required|int',
            'ville'=> 'required|int',*/
        ]);

        if($validator->fails()){
            $error = $validator->errors();
            return response()->json([
                'message' => "Un erreur s'est produit",
                'errors' => $error,
                'status' => 401,
            ],401);
        }

        //dd($validator->validate() , $classe->only(array_keys($validator->validate()))) ;
        // $diff = array_diff_assoc( 
        //     $validator->validate(), 
            
        //     $client->only(array_keys($validator->validate()))
        // ) ;

        // if(empty($diff)) {
        //     return response()->json([
        //         'message' => 'Aucune modification apportée',
        //     ], 200);
        // }

        $client->update( [
            'nom_societe'=> $request->nom_societe ?? null,
            'nom_contact'=> $request->nom_contact ?? null,
            'media_social' => $request->media_social ?? null,
            'commercial_id'=> $request->commercial_id ?? null,
            'email'=> $request->email ?? null,
            'nif'=> $request->nif ?? null,
            'stat'=> $request->stat ?? null,
            'rue'=> $request->rue ?? null,
            'ville'=> $request->ville ?? null,
            'telephone_1'=> $request->telephone_1 ?? null,
            'telephone_2'=> $request->telephone_2 ?? null,
        ]);

        return response()->json([
            'message' => "modification réussie",
            'client' => $client,
        ], 201);
    }

    public function delete(Request $request) {
        $id = $request->id_client ?? null;
        if( !$id) {
            return response()->json([
                'message' => "identifiant non définit"
            ]);
        }

        $client = Client::find($id);
        if(!$client) {
            return response()->json([
                "message" => "cette identifiant n'existe plus",
            ]);
        }

        $client->delete();
        return response()->json([
            'message' => "supprimer..."
        ]);
    }
}

