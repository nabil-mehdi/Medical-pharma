<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Infirmiere;
use App\Models\User;
use App\Models\Medecin;
use App\Models\Pharmacie;
use App\Models\RendezVous;


class RendezVouscontroller extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'type' => 'required|in:medecin,infirmier',
            'professionnel_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'heure' => 'required',
        ]);

        // Vérifie que le professionnel est bien du bon type

        if ($request->type === 'medecin') {
            $exists = \App\Models\Medecin::where('user_id', $request->professionnel_id)->exists();
        } else {
            $exists = \App\Models\Infirmiere::where('user_id', $request->professionnel_id)->exists();
        }
        if (!$exists) {
            return response()->json([
                'error' => "Le professionnel sélectionné n'est pas un(e) " . $request->type . "."
            ], 422);
        }


        $rdv = RendezVous::create([
            'patient_id' => $request->patient_id,
            'type' => $request->type,
            'professionnel_id' => $request->professionnel_id,
            'date' => $request->date,
            'heure' => $request->heure,
        ]);

        return response()->json($rdv, 201);
    }
    public function index()
    {
        $rendezVous = RendezVous::with('patient')
            ->get()
            ->map(function ($rdv) {
                // Récupération conditionnelle selon le type
                $professionnel = User::find($rdv->professionnel_id);

                return [
                    'id' => $rdv->id,
                    'patient_nom' => $rdv->patient->nom,
                    'patient_prenom' => $rdv->patient->prenom,
                    'patient_id' => $rdv->patient->id,
                    'type' => $rdv->type,
                    'professionnel_nom' => $professionnel ? $professionnel->nom : null,
                    'professionnel_prenom' => $rdv->professionnel->prenom,
                    'professionnel_id' => $rdv->professionnel_id,
                    'date' => $rdv->date,
                    'heure' => $rdv->heure,
                    'statut' => $rdv->statut,
                ];
            });

        return response()->json($rendezVous);
    }
    public function updateStatut(Request $request, $id)
    {
        $rendezVous = RendezVous::find($id);

        if (!$rendezVous) {
            return response()->json(['error' => 'Rendez-vous non trouvé'], 404);
        }

        $request->validate([
            'statut' => 'required|string|in:en_attente,confirme,annule,termine',
        ]);

        $rendezVous->statut = $request->statut;
        $rendezVous->save();

        return response()->json([
            'message' => 'Statut mis à jour avec succès',
            'rendezVous' => $rendezVous,
        ]);
    }
}
