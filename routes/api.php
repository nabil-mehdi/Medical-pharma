<?php

use App\Http\Controllers\Medecincontroller;
use App\Http\Controllers\Infirmiercontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RendezVouscontroller;
use App\Http\Controllers\Pharmaciecontroller;
use App\Http\Controllers\Specialitecontroller;
use App\Http\Controllers\Soincontroller;
use App\Http\Controllers\MessageController;
use App\Models\Infirmiere;
use App\Models\Pharmacie;
use App\Models\RendezVous;
use App\Models\Specialite;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login']);
Route::get('logout', [UserController::class, 'logout']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/rendezvous', [RendezVousController::class, 'store']);
Route::get('/rendezvous', [RendezVousController::class, 'index']);
Route::put('/rendezvous/{id}/statut', [RendezVousController::class, 'updateStatut']);
Route::get('/medecins', [Medecincontroller::class, 'index']);
Route::get('/medecinsfiltre', [Medecincontroller::class, 'filtrerMedecins']);
Route::get('/specialites', [Specialitecontroller::class, 'index']);
Route::get('/soins', [Soincontroller::class, 'index']);
Route::get('/infirmieres', [Infirmiercontroller::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('/users/{id}/update-photo', [UserController::class, 'updatephoto']);
Route::put('/users/{id}/update-motdepasse', [UserController::class, 'updatemotdepasse']);
Route::get('Pharmacie/{id}', [PharmacieController::class, 'getinfopharmacie']);
Route::get('pharmacies/proches', [PharmacieController::class, 'getPharmaciesProches']);
Route::get('/pharmacies/garde', [PharmacieController::class, 'getPharmaciesGarde']);
Route::put('Pharmacie/{id}/ouvert', [PharmacieController::class, 'updateOuvert']);
Route::post('/messages/send', [MessageController::class, 'sendMessage']);
Route::get('/messages/conversation/{userId}/{otherUserId}', [MessageController::class, 'getConversation']);
Route::put('/messages/{messageId}/{userId}/read', [MessageController::class, 'markAsRead']);
Route::get('/messages/unread/count', [MessageController::class, 'getUnreadCount']);
Route::get('/messages/{userId}', [MessageController::class, 'getallmessage']);









Route::get('/user/index', [UserController::class, 'index']);
