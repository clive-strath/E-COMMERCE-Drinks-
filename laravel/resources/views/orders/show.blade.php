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

                    {{-- Rating Section --}}
                    @if($order->status === 'delivered')
                        <div class="border-t pt-4 mt-6">
                            <h3 class="font-semibold mb-3">Rate Your Experience</h3>
                            
                            @if($order->rating)
                                {{-- Show existing rating --}}
                                <div class="space-y-2">
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $order->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    @if($order->rating_comment)
                                        <p class="text-sm text-gray-600 italic">"{{ $order->rating_comment }}"</p>
                                    @endif
                                    <p class="text-xs text-gray-500">Rated on {{ $order->rated_at->format('M d, Y') }}</p>
                                </div>
                            @else
                                {{-- Rating form --}}
                                <form action="{{ route('orders.rate', $order) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="text-sm font-medium mb-2 block">Your Rating</label>
                                        <div class="flex gap-2" id="star-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <input type="radio" name="rating" value="{{ $i }}" id="star-{{ $i }}" class="hidden peer/star-{{ $i }}" required>
                                                <label for="star-{{ $i }}" class="cursor-pointer">
                                                    <svg class="w-8 h-8 text-gray-300 hover:text-yellow-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                        @error('rating')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="rating_comment" class="text-sm font-medium mb-2 block">Comments (Optional)</label>
                                        <textarea name="rating_comment" id="rating_comment" rows="3" maxlength="500" 
                                                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" 
                                                  placeholder="Share your experience..."></textarea>
                                        @error('rating_comment')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                        Submit Rating
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
