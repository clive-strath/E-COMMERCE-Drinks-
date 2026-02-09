<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = auth()->user()->wishlists()->with('product')->latest()->paginate(10);
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = auth()->user();
        
        // Prevent duplicate entries
        if (!$user->wishlists()->where('product_id', $request->product_id)->exists()) {
            $user->wishlists()->create([
                'product_id' => $request->product_id,
            ]);
        }

        return back()->with('success', 'Product added to wishlist!');
    }

    public function destroy(Wishlist $wishlist)
    {
        // Ensure the user owns the wishlist item
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->delete();

        return back()->with('success', 'Product removed from wishlist!');
    }
}
