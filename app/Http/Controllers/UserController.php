<?php

namespace App\Http\Controllers;

use App\Models\Infirmier;
use App\Models\Infirmiere;
use App\Models\User;
use App\Models\Medecin;
use App\Models\Pharmacie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }

        $user = Auth::user();
        //$token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $user->token,
            'user' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'email' => $user->email,
                'role' => $user->role,
                'profile_photo_path' => $user->profile_photo_path,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $user =  Auth::logout();
        return response($user);
    }




    public function index()
    {
        return response()->json(User::all());
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users',
            'date_naissance' => 'required|date',
            'password' => 'required|confirmed',
            'role' => 'required|in:patient,medecin,pharmacie,infirmiere'
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'date_naissance' => $request->date_naissance,
            'password' => bcrypt($request->password),
            'role' => $request->role,

        ]);

        if ($user->role == 'medecin') {
            Medecin::create([
                'user_id' => $user->id,
                'specialite_id' => $request->specialite,
                'description' => $request->description,
            ]);
        }
        if ($user->role == 'pharmacie') {
            Pharmacie::create([
                'user_id' => $user->id,
                'nom_pharmacie' => $request->nom_pharmacie,
                'adresse' => $request->adresse,
                'ouvert' =>    $request->ouvert,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude

            ]);
        }
        if ($user->role == 'infirmiere') {
            Infirmiere::create([
                'user_id' => $user->id,
                'soin_id' => $request->soin_id,

            ]);
        }

        $token = $user->createToken("api_token")->plainTextToken;

        return response()->json([
            'user' => $user->load('medecinProfile', 'pharmacie', 'infirmierProfile'),
            'token' => $token,
        ]);
    }
    public function updatephoto(Request $request, $id)
    {

        $user = User::find($id);
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Générer un nom aléatoire pour la photo
            $extension = $request->file('photo')->getClientOriginalExtension();

            $randomName = uniqid() . '_' . time() . '.' . $extension;

            // Sauvegarder la photo dans le dossier storage/app/public/profile_photos
            $path = $request->file('photo')->storeAs(
                'profile_photos',
                $randomName,
                'public'
            );

            // Mettre à jour le chemin dans la base de données
            $user->profile_photo_path = $randomName;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Photo de profil mise à jour avec succès',
                'filename' => $randomName,
                'path' => $path
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'upload: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updatemotdepasse(Request $request, $id)
    {
        $user = User::find($id);

        // Vérifier l'ancien mot de passe
        $mdpuser = $request->input('passwordactu');
        if (!password_verify($mdpuser, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Ancien mot de passe incorrect',
            ], 400);
        }

        // Valider le nouveau mot de passe
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        // Mettre à jour le mot de passe
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Mot de passe mis à jour avec succès',
        ]);
    }
}
