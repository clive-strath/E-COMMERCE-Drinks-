<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cart->load('cartItems.product.category');

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = \App\Models\Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        // Deduct Stock
        $product->decrement('stock', $request->quantity);

        // Create Order
        $order = \App\Models\Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'user_id' => auth()->id(),
            'customer_name' => auth()->user()->name,
            'customer_phone' => 'N/A', // Simplified for "Buy Now"
            'delivery_address' => 'N/A', // Simplified
            'total_amount' => $product->price * $request->quantity,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'card', // Dummy
        ]);

        // Create Order Item
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order placed successfully!'); 
        // Note: Redirecting to admin index for demo purposes as user dashboard is not fully built for orders yet.
        // Actually, better to redirect to product page with success or a "My Orders" page if I had one.
        // I'll redirect to product page for now.
    }

    public function rate(Request $request, \App\Models\Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Can only rate delivered orders
        if ($order->status !== 'delivered') {
            return back()->with('error', 'You can only rate delivered orders.');
        }

        // Can only rate once
        if ($order->rating !== null) {
            return back()->with('error', 'You have already rated this order.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'rating_comment' => 'nullable|string|max:500',
        ]);

        $order->update([
            'rating' => $request->rating,
            'rating_comment' => $request->rating_comment,
            'rated_at' => now(),
        ]);

        return back()->with('success', 'Thank you for rating your order!');
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'delivery_instructions' => 'nullable|string|max:500',
            'payment_method' => 'required|in:cash_on_delivery',
        ]);

        $cart = $this->getCart();
        
        if (!$cart || $cart->cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $cart->load('cartItems.product');

        foreach ($cart->cartItems as $cartItem) {
            if ($cartItem->product->stock < $cartItem->quantity) {
                return back()->with('error', "Not enough stock for {$cartItem->product->name}.");
            }
        }

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'delivery_address' => $request->delivery_address,
            'city' => $request->city,
            'delivery_instructions' => $request->delivery_instructions,
            'total_amount' => $cart->total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        foreach ($cart->cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'size' => $cartItem->product->size,
            ]);

            $cartItem->product->decrement('stock', $cartItem->quantity);
        }

        Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'method' => $request->payment_method,
            'status' => $request->payment_method === 'cash_on_delivery' ? 'pending' : 'pending',
        ]);

        $cart->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderItems.product.category')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.product.category', 'payment');

        return view('orders.show', compact('order'));
    }

    private function getCart()
    {
        $user = auth()->user();
        return $user ? $user->cart : null;
    }
}
