<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $products = \App\Models\Product::all();
        return view('admin.categories.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'product_ids' => 'sometimes|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $category = new \App\Models\Category();
        $category->name = $validated['name'];
        $category->slug = \Illuminate\Support\Str::slug($validated['name']);
        $category->save();

        if (!empty($validated['product_ids'])) {
            \App\Models\Product::whereIn('id', $validated['product_ids'])->update(['category_id' => $category->id]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }
}
