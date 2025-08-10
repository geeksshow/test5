<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function index(Request $request)
    {
        $query = Laptop::active()->inStock();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('processor', 'like', "%{$search}%");
            });
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by RAM
        if ($request->filled('ram')) {
            $query->where('ram', $request->ram);
        }

        // Filter by storage
        if ($request->filled('storage')) {
            $query->where('storage', $request->storage);
        }

        // Sort functionality
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        
        if (in_array($sort, ['name', 'price', 'brand', 'created_at'])) {
            $query->orderBy($sort, $direction);
        }

        $laptops = $query->paginate(12)->withQueryString();

        // Get unique values for filters
        $brands = Laptop::active()->distinct()->pluck('brand')->sort();
        $rams = Laptop::active()->distinct()->pluck('ram')->sort();
        $storages = Laptop::active()->distinct()->pluck('storage')->sort();
        $priceRange = [
            'min' => Laptop::active()->min('price'),
            'max' => Laptop::active()->max('price')
        ];

        return view('laptop', compact('laptops', 'brands', 'rams', 'storages', 'priceRange'));
    }

    public function show(Laptop $laptop)
    {
        return view('laptop.show', compact('laptop'));
    }
}