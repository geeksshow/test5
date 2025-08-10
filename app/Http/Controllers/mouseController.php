<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mouseController extends Controller
{
    public function index()
    {
        return view('mouse'); 
    }
}
