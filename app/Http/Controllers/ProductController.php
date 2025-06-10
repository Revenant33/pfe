<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function orderHistory(Product $product)
{
    // Ensure only the product's owner can view
    if ($product->seller_id !== Auth::id()) {
        abort(403);
    }

    $orders = $product->orders()->with('user')->latest()->get();

    return view('products.order_history', compact('product', 'orders'));
}

    // Display a listing of the seller's products
    public function index()
    {
        $products = Auth::user()->products()->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        return view('products.create');
    }

    // Store a new product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'discount_price' => 'required|numeric|min:0|lt:original_price',
            'expiration_date' => 'required|date|after:today',
        ]);

        Auth::user()->products()->create($request->all());

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    // Show the form for editing a product
    public function edit(Product $product)
    {
        // Check if the logged-in user owns the product
        if ($product->seller_id !== Auth::id()) {
            abort(403);
        }
        return view('products.edit', compact('product'));
    }

    // Update the product in the database
    public function update(Request $request, Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'discount_price' => 'required|numeric|min:0|lt:original_price',
            'expiration_date' => 'required|date|after:today',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
    public function publicIndex()
{
    $products = Product::whereDate('expiration_date', '>', now())
        ->orderBy('discount_price')
        ->paginate(12);

    return view('products.public', compact('products'));
}

}
