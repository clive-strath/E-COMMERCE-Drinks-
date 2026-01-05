@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-lg font-semibold mb-6">Delivery Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name *
                                </label>
                                <input type="text" name="customer_name" id="customer_name" required
                                       value="{{ auth()->user()->name ?? '' }}"
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('customer_name')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number *
                                </label>
                                <input type="tel" name="customer_phone" id="customer_phone" required
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('customer_phone')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Delivery Address *
                                </label>
                                <textarea name="delivery_address" id="delivery_address" rows="3" required
                                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                @error('delivery_address')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                    City *
                                </label>
                                <input type="text" name="city" id="city" required
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('city')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="delivery_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                                    Delivery Instructions (Optional)
                                </label>
                                <textarea name="delivery_instructions" id="delivery_instructions" rows="3"
                                          placeholder="e.g., Ring the doorbell, Leave at the gate, etc."
                                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                @error('delivery_instructions')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold mb-6">Payment Method</h2>
                        
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="cash_on_delivery" checked
                                       class="mr-3 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <div class="font-medium">Cash on Delivery</div>
                                    <div class="text-sm text-gray-600">Pay when you receive your order</div>
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                        <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                        
                        <!-- Cart Items -->
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cart->cartItems as $item)
                                <div class="flex justify-between items-center">
                                    <div class="flex-1">
                                        <div class="font-medium text-sm">{{ $item->product->name }}</div>
                                        <div class="text-xs text-gray-600">{{ $item->quantity }} × ${{ number_format($item->price, 2) }}</div>
                                    </div>
                                    <div class="font-semibold">${{ number_format($item->subtotal, 2) }}</div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="border-t pt-4 space-y-3">
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

                        <button type="submit" 
                                class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold mt-6">
                            Place Order
                        </button>

                        <a href="{{ route('cart.index') }}" 
                           class="w-full bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-semibold text-center block mt-3">
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
