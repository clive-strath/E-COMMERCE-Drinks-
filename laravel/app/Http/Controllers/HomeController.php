<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::where('status', 'available')
            ->inRandomOrder()
            ->take(8)
            ->with('category')
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }
}
