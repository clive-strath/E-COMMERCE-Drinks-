@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

        @if($cart->cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold">Cart Items ({{ $cart->cartItems->count() }})</h2>
                        </div>
                        <div class="divide-y">
                            @foreach($cart->cartItems as $item)
                                <div class="p-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-20 h-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                            @if($item->product->image)
                                                <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain rounded-lg">
                                            @else
                                                <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold">{{ $item->product->name }}</h3>
                                            <p class="text-gray-600 text-sm">{{ $item->product->size }}</p>
                                            <p class="text-gray-600 text-sm">{{ $item->product->category->name }}</p>
                                            <p class="text-blue-600 font-semibold">${{ number_format($item->price, 2) }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('cart.update') }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                       min="1" max="{{ $item->product->stock }}" 
                                                       class="w-16 px-2 py-1 border rounded text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <button type="submit" class="text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="text-gray-600">Subtotal:</span>
                                        <span class="font-semibold">${{ number_format($item->subtotal, 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span>${{ number_format($cart->total, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Delivery:</span>
                                <span>Free</span>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between font-semibold text-lg">
                                    <span>Total:</span>
                                    <span class="text-blue-600">${{ number_format($cart->total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" 
                           class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-center block">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('products.index') }}" 
                           class="w-full bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-semibold text-center block mt-3">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                </svg>
                <h2 class="text-2xl font-bold mb-4">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">Looks like you haven't added any drinks to your cart yet.</p>
                <a href="{{ route('products.index') }}" 
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold inline-block">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
