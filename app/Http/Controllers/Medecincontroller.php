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
}
