<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::with(['user', 'items.product'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;

        // If marking as delivered, ensure payment is marked as paid
        if ($request->status === 'delivered' && $order->payment_status !== 'paid') {
            $order->payment_status = 'paid';
        }

        $order->save();

        // Send notification to user when order is delivered
        if ($request->status === 'delivered' && $oldStatus !== 'delivered') {
            $order->user->notify(new \App\Notifications\OrderDelivered($order));
        }

        return back()->with('success', 'Order status updated successfully.');
    }
}
