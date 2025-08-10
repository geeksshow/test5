<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'laptop_id' => 'required|exists:laptops,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $laptopId = $request->laptop_id;
        $quantity = $request->quantity ?? 1;

        // Get laptop details
        $laptop = Laptop::findOrFail($laptopId);

        // Check stock
        if ($laptop->stock_quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available'
            ], 400);
        }

        // Get current cart from session
        $cart = session()->get('cart', []);

        // Add or update item in cart
        if (isset($cart[$laptopId])) {
            $cart[$laptopId]['quantity'] += $quantity;
        } else {
            $cart[$laptopId] = [
                'id' => $laptop->id,
                'name' => $laptop->name,
                'price' => $laptop->price,
                'quantity' => $quantity,
                'image' => $laptop->image
            ];
        }

        // Save cart to session
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Added to cart successfully',
            'cart_count' => count($cart)
        ]);
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart', compact('cart', 'total'));
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'laptop_id' => 'required|exists:laptops,id'
        ]);

        $cart = session()->get('cart', []);
        $laptopId = $request->laptop_id;

        if (isset($cart[$laptopId])) {
            unset($cart[$laptopId]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Removed from cart'
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'laptop_id' => 'required|exists:laptops,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        $laptopId = $request->laptop_id;
        $quantity = $request->quantity;

        if (isset($cart[$laptopId])) {
            $cart[$laptopId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated'
        ]);
    }
}
