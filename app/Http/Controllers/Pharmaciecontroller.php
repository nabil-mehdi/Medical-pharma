<?php

namespace App\Http\Controllers;

use App\Models\Pharmacie;
use Illuminate\Http\Request;

class PharmacieController extends Controller
{
    public function getPharmaciesProches(Request $request)
    {
        // Récupérer toutes les pharmacies
        $pharmacies = Pharmacie::select(
            'id',
            'user_id',
            'nom_pharmacie',
            'adresse',
            'ouvert',
            'latitude',
            'longitude',
            'created_at',
            'updated_at'
        )
            ->get();

        return response()->json($pharmacies);
    }

    public function getPharmaciesGarde(Request $request)
    {
        // Récupérer uniquement les pharmacies de garde (ouvertes)
        $pharmacies = Pharmacie::where('ouvert', 1)
            ->select(
                'id',
                'user_id',
                'nom_pharmacie',
                'adresse',
                'ouvert',
                'latitude',
                'longitude',
                'created_at',
                'updated_at'
            )
            ->get();

        return response()->json($pharmacies);
    }
    public function getinfopharmacie($id)
    {
        $pharmacies = Pharmacie::where('user_id', $id)->first();

        if (!$pharmacies) {
            return response()->json(['error' => 'Pharmacie non trouvée'], 404);
        }

        return response()->json($pharmacies);
    }
    public function updateOuvert($id)
    {
        $pharmacies = Pharmacie::findOrFail($id);

        // Récupérer le statut depuis le body de la requête
        $nouveauStatut = request()->input('ouvert');

        // Mettre à jour le statut
        $pharmacies->ouvert = $nouveauStatut;
        $pharmacies->save();

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
            'ouvert' => $pharmacies->ouvert
        ]);
    }
}
