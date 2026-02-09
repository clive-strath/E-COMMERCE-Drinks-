@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Add New Category</h1>
            <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Back to Categories
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Products</label>
                    <p class="text-sm text-gray-500 mb-3">Select products to move to this new category.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto border p-4 rounded-lg">
                        @foreach($products as $product)
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded">
                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" id="product_{{ $product->id }}"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="product_{{ $product->id }}" class="flex items-center space-x-3 cursor-pointer w-full">
                                    <div class="h-8 w-8 bg-gray-100 rounded-md overflow-hidden flex-shrink-0">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <span class="block text-sm font-medium text-gray-900">{{ $product->name }}</span>
                                        <span class="block text-xs text-gray-500">{{ $product->category->name }} &bull; ${{ $product->price }}</span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
