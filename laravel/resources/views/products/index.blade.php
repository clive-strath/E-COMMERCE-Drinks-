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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition flex flex-col h-full">
                    <a href="{{ route('products.show', $product) }}" class="h-64 w-full bg-white rounded-t-lg flex items-center justify-center overflow-hidden p-4 border-b border-gray-100 block">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain">
                        @else
                            <svg class="w-20 h-20 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                            </svg>
                        @endif
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-wide">{{ $product->category->name }}</span>
                            <h3 class="font-bold text-xl mt-1 text-gray-900">{{ $product->name }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ $product->size }}</p>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-6 flex-grow line-clamp-3">{{ $product->description }}</p>
                        
                        <div class="mt-auto">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                <span class="text-sm font-medium {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->stock > 0 ? "In Stock" : 'Out of stock' }}
                                </span>
                            </div>
                            
                            <div class="flex gap-3">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="flex-1 bg-gray-100 text-gray-800 px-4 py-2.5 rounded-lg text-center font-medium hover:bg-gray-200 transition focus:ring-2 focus:ring-gray-300 focus:outline-none">
                                    Details
                                </a>
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                            Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="flex-1 bg-gray-100 text-gray-400 px-4 py-2.5 rounded-lg font-medium cursor-not-allowed">
                                        Add to Cart
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
