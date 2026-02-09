@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Back to Orders
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Order #{{ $order->order_number }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Customer Information</h3>
                    <p class="text-gray-600"><span class="font-medium">Name:</span> {{ $order->customer_name }}</p>
                    <p class="text-gray-600"><span class="font-medium">Phone:</span> {{ $order->customer_phone }}</p>
                    <p class="text-gray-600"><span class="font-medium">Address:</span> {{ $order->delivery_address }}</p>
                    @if($order->city)
                        <p class="text-gray-600"><span class="font-medium">City:</span> {{ $order->city }}</p>
                    @endif
                </div>

                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Order Status</h3>
                    <p class="text-gray-600 mb-2">
                        <span class="font-medium">Status:</span> 
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                               'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </p>
                    <p class="text-gray-600 mb-2">
                        <span class="font-medium">Payment Status:</span> 
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    <p class="text-gray-600"><span class="font-medium">Payment Method:</span> {{ ucfirst($order->payment_method) }}</p>
                    <p class="text-gray-600"><span class="font-medium">Order Date:</span> {{ $order->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>

            <h3 class="font-semibold text-gray-700 mb-3">Products Ordered</h3>
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->product ? $item->product->name : 'Unknown Product' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-900">Total Amount:</td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-900">
                                ${{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-6">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="delivered">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        Mark as Delivered
                    </button>
                </form>
            @endif

            {{-- Customer Rating --}}
            @if($order->rating)
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Customer Rating</h3>
                    <div class="flex items-center gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $order->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                        <span class="ml-2 text-sm font-semibold text-gray-700">{{ $order->rating }}/5</span>
                    </div>
                    @if($order->rating_comment)
                        <p class="text-sm text-gray-700 italic">"{{ $order->rating_comment }}"</p>
                    @endif
                    <p class="text-xs text-gray-500 mt-2">Rated on {{ $order->rated_at->format('M d, Y H:i') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
