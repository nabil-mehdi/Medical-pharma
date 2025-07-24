<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use Illuminate\Http\Request;

class Medecincontroller extends Controller
{
    public function index()
    {
        $medecins = Medecin::all();
        return response()->json($medecins);
    }
    public function filtrerMedecins(Request $request)
    {
        $query = Medecin::with('user');

        if ($request->filled('nom')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->nom . '%')
                    ->orWhere('prenom', 'like', '%' . $request->nom . '%');
            });
        }

        if ($request->filled('specialite')) {
            $query->where('specialite_id', $request->specialite);
        }

        $medecins = $query->get();

        return response()->json($medecins);
    }
}
