<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('cartItems.product.category');

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = $this->getOrCreateCart();
        
        $cartItem = $cart->cartItems()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cartItem = CartItem::findOrFail($request->item_id);
        $this->authorizeCartAccess($cartItem->cart);

        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
        ]);

        $cartItem = CartItem::findOrFail($request->item_id);
        $this->authorizeCartAccess($cartItem->cart);
        
        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    private function getOrCreateCart()
    {
        $user = auth()->user();
        
        if ($user) {
            return $user->cart ?? $user->cart()->create();
        }

        return Cart::firstOrCreate(['user_id' => null]);
    }

    private function authorizeCartAccess(Cart $cart)
    {
        if (auth()->id() !== $cart->user_id) {
            abort(403);
        }
    }
}
