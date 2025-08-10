<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getFeaturedProducts()
    {
        try {
            $products = Laptop::where('is_featured', true)
                             ->where('is_active', true)
                             ->where('stock_quantity', '>', 0)
                             ->limit(6)
                             ->get();

            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading featured products'
            ], 500);
        }
    }

    public function getCartCount()
    {
        try {
            $cart = session()->get('cart', []);
            $count = count($cart);

            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'count' => 0
            ]);
        }
    }
}