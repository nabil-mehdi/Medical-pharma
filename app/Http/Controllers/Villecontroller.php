<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;

class Villecontroller extends Controller
{
    public function index()
    {
        return response()->json(Ville::all());
    }
}
