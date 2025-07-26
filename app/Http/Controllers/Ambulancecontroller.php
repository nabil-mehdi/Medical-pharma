<?php

namespace App\Http\Controllers;

use App\Models\Ambulance;
use Illuminate\Http\Request;


class Ambulancecontroller extends Controller
{
    public function index()
    {
        return response()->json(Ambulance::with(['user', 'ville'])->get());
    }
    public function getinfoambulance($id)
    {
        $ambulance = Ambulance::with('ville')->where('user_id', $id)->first();

        if (!$ambulance) {
            return response()->json(['error' => 'Ambulance non trouvée'], 404);
        }

        return response()->json($ambulance);
    }
    public function updatedispo($id)
    {
        $ambulance = Ambulance::findOrFail($id);

        // Récupérer le statut depuis le body de la requête
        $nouveauStatut = request()->input('disponible');

        // Mettre à jour le statut
        $ambulance->disponible = $nouveauStatut;
        $ambulance->save();

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
            'disponible' => $ambulance->disponible
        ]);
    }
}
