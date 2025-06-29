<?php

namespace App\Http\Controllers;

use App\Models\Accessoir;
use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Couverture;
use App\Models\Dimension;
use App\Models\Livre;
use App\Models\Papier;
use App\Models\Reliure;
use Illuminate\Http\Request;

class EstimateBookController extends Controller
{
    public function type() {
        return response()->json([
            'status' => 200,
            'type' => Livre::all(),
        ]);
    }

    public function dimension() {
        return response()->json([
            'status' => 200,
            'dimension' => Dimension::all(),
        ]);
    }

     public function papier() {

        //$papiers = Papier::with(['categorie', 'accessoir'])->get();
        $papiers = Categorie::with(['papiers.accessoir'])->get()->map(function($categorie){
            return [
                'categorie' => $categorie->categorie,
                'accessoire' => $categorie->papiers->filter(fn($p) => $p->accessoir !== null)->values()
            ];
        });
        return response()->json([
            'status' => 200,
            'papiers' => $papiers,

        ]);
    }

    public function couleur(){
        $couleur = Couleur::all();
        return response()->json([
            'status' => 200,
            'couleurs' => $couleur,
        ]);
    }

     public function couverture(){
        $couverture = Couverture::all();
        return response()->json([
            'status' => 200,
            'couvertures' => $couverture,
        ]);
    }

    public function reliure(){
        $reliure = Reliure::all();
        return response()->json([
            'status' => 200,
            'couvertures' => $reliure,
        ]);
    }
}
