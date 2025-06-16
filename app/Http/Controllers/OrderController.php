<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
    $orders = Auth::user()
        ->orders()
        ->with('product')
        ->orderByDesc('created_at')
        ->get()
        ->groupBy(function ($order) {
            return $order->created_at->format('Y-m-d H:i:s'); // Group by exact timestamp
        });

    return view('orders.index', compact('orders'));
    }


    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $total = $product->discount_price * $validated['quantity'];

        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'total_price' => $total,
        ]);
        $product->increment('times_sold', $validated['quantity']);

        return redirect()->route('orders.index')->with('success', 'Order placed!');
    }
}
