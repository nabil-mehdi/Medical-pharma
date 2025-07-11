<?php

namespace App\Http\Controllers;

use App\Models\Specialite;
use Illuminate\Http\Request;

class Specialitecontroller extends Controller
{
    public function index()
    {
        return response()->json(Specialite::all());
    }
}
