<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeControllers extends Controller
{
    public function index()
    {
        $data = [
            'hero_title' => 'Your Professional Title',
            'hero_subtitle' => 'Compelling subtitle here',
            'features' => [
                ['title' => 'Feature 1', 'description' => 'Description'],
                ['title' => 'Feature 2', 'description' => 'Description'],
                ['title' => 'Feature 3', 'description' => 'Description'],
            ]
        ];
        
        return view('home-hero', compact('data'));
    }
}
