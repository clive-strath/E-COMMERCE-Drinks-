@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8">My Wishlist</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($wishlistItems->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($wishlistItems as $item)
                        <div class="border rounded-lg p-4 flex flex-col relative group">
                            <form action="{{ route('wishlist.destroy', $item) }}" method="POST" class="absolute top-2 right-2 z-10">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-500 bg-white rounded-full p-1 shadow-sm hover:shadow-md transition" title="Remove from Wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                            
                            <a href="{{ route('products.show', $item->product) }}" class="block">
                                <div class="h-48 w-full flex items-center justify-center mb-4 bg-gray-50 rounded-md overflow-hidden">
                                     @if($item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                        </svg>
                                    @endif
                                </div>
                                
                                <h3 class="font-bold text-lg mb-1 text-gray-900 group-hover:text-blue-600 transition">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $item->product->size }}</p>
                                <p class="font-bold text-gray-900 mb-4">${{ number_format($item->product->price, 2) }}</p>
                            </a>

                            <div class="mt-auto">
                                @if($item->product->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                            Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-100 text-gray-400 px-4 py-2 rounded cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $wishlistItems->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center py-12">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h2 class="text-xl font-medium text-gray-900 mb-2">Your wishlist is empty</h2>
                    <p class="text-gray-500 mb-6">Save items you want to buy later.</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        Browse Products
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
