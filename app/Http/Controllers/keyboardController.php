<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class keyboardController extends Controller
{
    public function index()
    {
        return view('keyboard'); 
    }
}
