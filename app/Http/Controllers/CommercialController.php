<?php

namespace App\Http\Controllers;

use App\Models\Commercial;
use Illuminate\Http\Request;

class CommercialController extends Controller
{
    public function get(){
        $commerciaux = Commercial::all()->map( function( $commercial) {
            return [
                'id_commercial' => $commercial->id_commercial ?? null,
                'nom' => $commercial->nom ?? null,
                'prenom' => $commercial->prenom ?? null,
                'contact' => $commercial->contact ?? null,
                'adresse' => $commercial->adresse ?? null,
            ];
        });
        return response()->json([
            'commerciaux' => $commerciaux,
        ]);

    }

    public function create(Request $request) {
        return response()->json([
            'messsage' => "Agent commercial ajouté avec succès"
        ]);
    } 
}
