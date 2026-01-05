@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Order {{ $order->order_number }}</h1>
                    <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                           ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                           'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2">
                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Order Items</h2>
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center gap-4 pb-4 border-b last:border-b-0">
                                <div class="w-16 h-10 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain rounded-lg">
                                    @else
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold">{{ $item->product->name }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $item->size }}</p>
                                    <p class="text-gray-600 text-sm">{{ $item->product->category->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-600 text-sm">{{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                    <p class="font-semibold">${{ number_format($item->subtotal, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Delivery Information</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-600 text-sm">Recipient:</span>
                            <p class="font-medium">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm">Phone:</span>
                            <p class="font-medium">{{ $order->customer_phone }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm">Address:</span>
                            <p class="font-medium">{{ $order->delivery_address }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm">City:</span>
                            <p class="font-medium">{{ $order->city }}</p>
                        </div>
                        @if($order->delivery_instructions)
                            <div>
                                <span class="text-gray-600 text-sm">Delivery Instructions:</span>
                                <p class="font-medium">{{ $order->delivery_instructions }}</p>
                            </div>
                        @endif
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
                            <span>${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Delivery:</span>
                            <span>Free</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between font-semibold text-lg">
                                <span>Total:</span>
                                <span class="text-blue-600">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h3 class="font-semibold mb-3">Payment Information</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600 text-sm">Method:</span>
                                <span class="text-sm">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 text-sm">Status:</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                                       ($order->payment_status === 'failed' ? 'bg-red-100 text-red-800' : 
                                       'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        @if($order->status === 'pending')
                            <a href="{{ route('products.index') }}" 
                               class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-center block">
                                Continue Shopping
                            </a>
                        @endif
                        
                        <a href="{{ route('orders.index') }}" 
                           class="w-full bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-semibold text-center block">
                            View All Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
