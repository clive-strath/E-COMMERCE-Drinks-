@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-8 mb-8 text-white">
            <h1 class="text-4xl font-bold mb-4">Welcome to Drinks Store</h1>
            <p class="text-xl mb-6">Fresh drinks delivered to your doorstep</p>
            <a href="{{ route('products.index') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Shop Now
            </a>
        </div>

        <!-- Categories -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                       class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold">{{ $category->name }}</h3>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Featured Products -->
        <div>
            <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                        <div class="h-24 w-full bg-gray-200 rounded-t-lg flex items-center justify-center overflow-hidden">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-contain rounded-t-lg">
                            @else
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="p-3">
                            <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $product->size }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
