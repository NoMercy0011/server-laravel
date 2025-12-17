<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\CatalogueType;
use App\Models\Face;
use App\Models\OrientationCatalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function getPackaging(){
        $face = Face::all(); 
        $packaging_id = Catalogue::where( "code" , "=", "packaging")->first()->id;
        
        $catalogueType = CatalogueType::where('catalogue_id', '=', $packaging_id)
        ->with([
            'catalogue',
            'dimensions',
            'matieres.inventaire',
            'decoupes',
            'couleurs',
            'emplacements',
            'finitions',
            'imprimantes',
            'particularites',
        ])->get()->map( function ($catalogueType) use($face)  {
            return [   
                    "id" => $catalogueType->id,
                    "type" => $catalogueType->type,
                    "code" => $catalogueType->code,
                    "catalogue" => [
                        "id" => $catalogueType->catalogue->id,
                        "catalogue" => $catalogueType->catalogue->catalogue,
                        "code" => $catalogueType->catalogue->code,
                    ],
                    "dimensions" => $catalogueType->dimensions->map( function ($dimension) {
                        return [
                            "id"=> $dimension->id,
                            "dimension" => $dimension->dimension,
                            "ratio" => $dimension->ratio,
                        ];
                    }),
                    "matieres" => $catalogueType->matieres->map( function ($matiere) {
                        return [
                            "id"=> $matiere->inventaire->id,
                            "type" => $matiere->inventaire->type,
                            "details" => $matiere->inventaire->details,
                            "longueur" => $matiere->inventaire->longueur,
                            "largeur" => $matiere->inventaire->largeur,
                            "caracteristiques" => $matiere->inventaire->caracteristiques,
                            "taille" => $matiere->inventaire->taille,
                            "rendement" => $matiere->inventaire->rendement,
                            "par" => $matiere->inventaire->par,
                            "prix_unitaire" => $matiere->inventaire->prix_unitaire,
                            "unitee" => $matiere->inventaire->unitee,
                        ];
                    }),
                    "decoupes" => $catalogueType->decoupes->map( function ($decoupe) {
                        return [
                            "id"=> $decoupe->id,
                            "decoupe" => $decoupe->decoupe,
                            "prix" => $decoupe->prix,
                        ];
                    }),
                    "couleurs" => $catalogueType->couleurs->map( function ($couleur) {
                        return [
                            "id"=> $couleur->id,
                            "couleur" => $couleur->couleur,
                        ];
                    }),
                    "emplacements" => $catalogueType->emplacements->map( function ($emplacement) {
                        return [
                            "id"=> $emplacement->id,
                            "emplacement" => $emplacement->emplacement,
                        ];
                    }),
                    "finitions" => $catalogueType->finitions->map( function ($finition) {
                        return [
                            "id"=> $finition->id,
                            "finition" => $finition->finition,
                        ];
                    }),
                    "imprimantes" => $catalogueType->imprimantes->map( function ($imprimante) {
                        return [
                            "id"=> $imprimante->id,
                            "imprimante" => $imprimante->imprimante,
                        ];
                    }),
                    "particularites" => $catalogueType->particularites->map( function ($particularite) {
                        return [
                            "id"=> $particularite->id,
                            "particularite" => $particularite->particularite,
                        ];
                    }),
                    "faces" => $face
            ];
        });

        return response()->json([
            "packaging" => $catalogueType,
        ]);
    }

    public function getCalendar() {
        $face = Face::all(); 
        $calendar_id = Catalogue::where( "code" , "=", "calendar")->first()->id;
        $catalogueType = CatalogueType::where('catalogue_id', '=', $calendar_id)
        ->with([ 
            'catalogue', 'dimensions','matieres.inventaire','imprimantes','socles', 'particularites'

        ])->get()->map ( function ($catalogueType) use($face)  {
            return [   
                    //'calendar' => $catalogueType,
                    "id" => $catalogueType->id,
                    "type" => $catalogueType->type,
                    "code" => $catalogueType->code,
                    "catalogue" => [
                        "id" => $catalogueType->catalogue->id,
                        "catalogue" => $catalogueType->catalogue->catalogue,
                        "code" => $catalogueType->catalogue->code,
                    ],
                    "dimensions" => $catalogueType->dimensions->map( function ($dimension) {
                        return [
                            "id"=> $dimension->id,
                            "dimension" => $dimension->dimension,
                            "ratio" => $dimension->ratio,
                        ];
                    }),
                    "matieres" => $catalogueType->matieres->map( function ($matiere) {
                        return [
                            "id"=> $matiere->inventaire->id,
                            "type" => $matiere->inventaire->type,
                            "details" => $matiere->inventaire->details,
                            "longueur" => $matiere->inventaire->longueur,
                            "largeur" => $matiere->inventaire->largeur,
                            "caracteristiques" => $matiere->inventaire->caracteristiques,
                            "taille" => $matiere->inventaire->taille,
                            "rendement" => $matiere->inventaire->rendement,
                            "par" => $matiere->inventaire->par,
                            "prix_unitaire" => $matiere->inventaire->prix_unitaire,
                            "unitee" => $matiere->inventaire->unitee,
                        ];
                    }),
                    "faces" => $face,
                    "imprimantes" => $catalogueType->imprimantes->map( function ($imprimante) {
                        return [
                            "id"=> $imprimante->id,
                            "imprimante" => $imprimante->imprimante,
                        ];
                    }),
                    "socles" => $catalogueType->socles->map( function ($socle) {
                        return [
                            "id"=> $socle->id,
                            "socle" => $socle->socle,
                        ];
                    }),
                    "particularites" => $catalogueType->particularites->map( function ($particularite) {
                        return [
                            "id"=> $particularite->id,
                            "particularite" => $particularite->particularite,
                        ];
                    }),

            ];
        });
        return response()->json([
            "calendar" => $catalogueType,
        ]);
    }


    public function getChevalet() {
        $face = Face::all(); 
        $orientation = OrientationCatalogue::all();

        $chevalet_id = Catalogue::where( "code" , "=", "chevalet")->first()->id;
        $catalogueType = CatalogueType::where('catalogue_id', '=', $chevalet_id)
        ->with([ 
            'catalogue', 'dimensions','matieres.inventaire','coutures', 'particularites', 'socles' 
        ])->get()->map ( function ($catalogueType) use($face, $orientation)  {
            return [   
                    "id" => $catalogueType->id,
                    "type" => $catalogueType->type,
                    "code" => $catalogueType->code,
                    "catalogue" => [
                        "id" => $catalogueType->catalogue->id,
                        "catalogue" => $catalogueType->catalogue->catalogue,
                        "code" => $catalogueType->catalogue->code,
                    ],
                    "dimensions" => $catalogueType->dimensions->map( function ($dimension) {
                        return [
                            "id"=> $dimension->id,
                            "dimension" => $dimension->dimension,
                            "ratio" => $dimension->ratio,
                        ];
                    }),
                    "socles" => $catalogueType->socles->map( function ($socle) {
                        return [
                            "id"=> $socle->id,
                            "socle" => $socle->socle,
                        ];
                    }),
                    "matieres" => $catalogueType->matieres->map( function ($matiere) {
                        return [
                            "id"=> $matiere->inventaire->id,
                            "type" => $matiere->inventaire->type,
                            "details" => $matiere->inventaire->details,
                            "longueur" => $matiere->inventaire->longueur,
                            "largeur" => $matiere->inventaire->largeur,
                            "caracteristiques" => $matiere->inventaire->caracteristiques,
                            "taille" => $matiere->inventaire->taille,
                            "rendement" => $matiere->inventaire->rendement,
                            "par" => $matiere->inventaire->par,
                            "prix_unitaire" => $matiere->inventaire->prix_unitaire,
                            "unitee" => $matiere->inventaire->unitee,
                        ];
                    }),
                    "particularites" => $catalogueType->particularites->map( function ($particularite) {
                        return [
                            "id"=> $particularite->id,
                            "particularite" => $particularite->particularite,
                        ];
                    }),
                    "orientations" => $orientation,
                    "faces" => $face,

                ];
        });

        return response()->json([
            "chevalet" => $catalogueType,
        ]);
    }

    public function getCarterie()
    {
        $face = Face::all(); 
        $carterie_id = Catalogue::where( "code" , "=", "carterie")->first()->id;
        $catalogueType = CatalogueType::where('catalogue_id', '=', $carterie_id)
        ->with([ 
            'catalogue', 'dimensions','matieres.inventaire','imprimantes','decoupes'
        ])->get()->map ( function ($catalogueType) use($face)  {
            return [   
                    "id" => $catalogueType->id,
                    "type" => $catalogueType->type,
                    "code" => $catalogueType->code,
                    "catalogue" => [
                        "id" => $catalogueType->catalogue->id,
                        "catalogue" => $catalogueType->catalogue->catalogue,
                        "code" => $catalogueType->catalogue->code,
                    ],
                    "dimensions" => $catalogueType->dimensions->map( function ($dimension) {
                        return [
                            "id"=> $dimension->id,
                            "dimension" => $dimension->dimension,
                            "ratio" => $dimension->ratio,
                        ];
                    }),
                    "matieres" => $catalogueType->matieres->map( function ($matiere) {
                        return [
                            "id"=> $matiere->inventaire->id,
                            "type" => $matiere->inventaire->type,
                            "details" => $matiere->inventaire->details,
                            "longueur" => $matiere->inventaire->longueur,
                            "largeur" => $matiere->inventaire->largeur,
                            "caracteristiques" => $matiere->inventaire->caracteristiques,
                            "taille" => $matiere->inventaire->taille,
                            "rendement" => $matiere->inventaire->rendement,
                            "par" => $matiere->inventaire->par,
                            "prix_unitaire" => $matiere->inventaire->prix_unitaire,
                            "unitee" => $matiere->inventaire->unitee,
                        ];
                    }),
                    "decoupes" => $catalogueType->decoupes->map( function ($decoupe) {
                        return [
                            "id"=> $decoupe->id,
                            "decoupe" => $decoupe->decoupe,
                            "prix" => $decoupe->prix,
                        ];
                    }),
                    "imprimantes" => $catalogueType->imprimantes->map( function ($imprimante) {
                        return [
                            "id"=> $imprimante->id,
                            "imprimante" => $imprimante->imprimante,    
                        ];  
                    }),
                    "faces" => $face,
            ];
        });
        return response()->json([
            "carterie" => $catalogueType,
        ]);
    }
}