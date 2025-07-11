<?php

namespace App\Http\Controllers;

use App\Models\Infirmiere;
use Illuminate\Http\Request;

class Infirmiercontroller extends Controller
{
    public function index()
    {
        return response()->json(Infirmiere::all());
    }
}
