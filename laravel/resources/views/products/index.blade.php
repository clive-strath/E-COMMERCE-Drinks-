@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8">Our Products</h1>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search products..." 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <select name="category" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'category']))
                    <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                    <div class="h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover rounded-t-lg">
                        @else
                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="p-4">
                        <span class="text-xs text-blue-600 font-semibold">{{ $product->category->name }}</span>
                        <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $product->size }}</p>
                        <p class="text-gray-700 text-sm mb-3">{{ Str::limit($product->description, 80) }}</p>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-2xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                            <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stock > 0 ? "{$product->stock} in stock" : 'Out of stock' }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('products.show', $product) }}" 
                               class="flex-1 bg-gray-200 text-gray-800 px-3 py-2 rounded text-center hover:bg-gray-300 transition">
                                View Details
                            </a>
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition">
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <button disabled class="flex-1 bg-gray-300 text-gray-500 px-3 py-2 rounded cursor-not-allowed">
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
