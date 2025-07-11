<?php

namespace App\Http\Controllers;

use App\Models\Soin;
use Illuminate\Http\Request;

class Soincontroller extends Controller
{
    public function index()
    {
        return response()->json(Soin::all());
    }
}
