<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Display cart items
    public function index()
    {
        $cart = Auth::user()->cart()->with('items.product')->firstOrCreate([]);
        return view('cart.index', compact('cart'));
    }

    // Add product to cart
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
            
        ]);

        $cart = Auth::user()->cart()->firstOrCreate([]);

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->quantity += $request->quantity;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    // Remove product from cart
    public function remove(CartItem $item)
    {
        // Make sure this item belongs to the logged-in user's cart
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();
        return back()->with('success', 'Item removed from cart.');
    }

    // Checkout (convert cart items to orders)
    public function checkout()
    {
        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }

        foreach ($cart->items as $item) {
            $product = $item->product;

            $user->orders()->create([
                'product_id' => $product->id,
                'quantity' => $item->quantity,
                'total_price' => $item->quantity * $product->discount_price,
            ]);
             $product->times_sold += $item->quantity;
        $product->save();
        }

        // Clear cart
        $cart->items()->delete();

        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }
}
