@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Home</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Products</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li class="text-gray-600">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="bg-white rounded-lg shadow p-8">
                <div class="h-48 w-full bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-contain rounded-lg">
                    @else
                        <svg class="w-32 h-32 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                        </svg>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="bg-white rounded-lg shadow p-8">
                <span class="text-sm text-blue-600 font-semibold">{{ $product->category->name }}</span>
                <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                
                <div class="mb-6">
                    <span class="text-3xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                    <span class="text-gray-600 ml-2">{{ $product->size }}</span>
                </div>

                <div class="mb-6">
                    <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock > 0 ? "{$product->stock} items in stock" : 'Out of stock' }}
                    </span>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p class="text-gray-700">{{ $product->description }}</p>
                </div>

                @if($product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center gap-4 mb-4">
                            <label for="quantity" class="text-sm font-medium">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                   class="w-20 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                            Add to Cart
                        </button>
                    </form>
                @else
                    <button disabled class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-lg cursor-not-allowed font-semibold mb-6">
                        Out of Stock
                    </button>
                @endif

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Product Details</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Category:</dt>
                            <dd class="font-medium">{{ $product->category->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Size:</dt>
                            <dd class="font-medium">{{ $product->size }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Availability:</dt>
                            <dd class="font-medium {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Related Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                            <div class="h-16 w-full bg-gray-200 rounded-t-lg flex items-center justify-center overflow-hidden">
                                @if($relatedProduct->image)
                                    <img src="{{ Storage::url($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="h-full w-full object-contain rounded-t-lg">
                                @else
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-sm mb-2">{{ $relatedProduct->name }}</h3>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-blue-600">${{ number_format($relatedProduct->price, 2) }}</span>
                                    <a href="{{ route('products.show', $relatedProduct) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
