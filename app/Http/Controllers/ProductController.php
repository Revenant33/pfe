<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use Illuminate\Support\Facades\Storage;
=======
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c

class ProductController extends Controller
{
    public function orderHistory(Product $product)
<<<<<<< HEAD
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403);
        }

        $orders = $product->orders()->with('user')->latest()->get();
        return view('products.order_history', compact('product', 'orders'));
    }

=======
{
    // Ensure only the product's owner can view
    if ($product->seller_id !== Auth::id()) {
        abort(403);
    }

    $orders = $product->orders()->with('user')->latest()->get();

    return view('products.order_history', compact('product', 'orders'));
}

    // Display a listing of the seller's products
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c
    public function index()
    {
        $products = Auth::user()->products()->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

<<<<<<< HEAD
=======
    // Show the form for creating a new product
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c
    public function create()
    {
        return view('products.create');
    }

<<<<<<< HEAD
=======
    // Store a new product in the database
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'discount_price' => 'required|numeric|min:0|lt:original_price',
            'expiration_date' => 'required|date|after:today',
<<<<<<< HEAD
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'name', 'description', 'original_price', 
            'discount_price', 'expiration_date'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Auth::user()->products()->create($data);
=======
        ]);

        Auth::user()->products()->create($request->all());
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

<<<<<<< HEAD
    public function edit(Product $product)
    {
=======
    // Show the form for editing a product
    public function edit(Product $product)
    {
        // Check if the logged-in user owns the product
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c
        if ($product->seller_id !== Auth::id()) {
            abort(403);
        }
        return view('products.edit', compact('product'));
    }

<<<<<<< HEAD
=======
    // Update the product in the database
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c
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
<<<<<<< HEAD
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'name', 'description', 'original_price',
            'discount_price', 'expiration_date'
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
=======
        ]);

        $product->update($request->all());
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

<<<<<<< HEAD
=======
    // Delete a product
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c
    public function destroy(Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403);
        }

<<<<<<< HEAD
        // Supprimer l'image associée si elle existe
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

=======
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
<<<<<<< HEAD

    public function publicIndex()
    {
        $products = Product::whereDate('expiration_date', '>', now())
            ->orderBy('discount_price')
            ->paginate(12);

        return view('products.public', compact('products'));
    }
}
=======
    public function publicIndex()
{
    $products = Product::whereDate('expiration_date', '>', now())
        ->orderBy('discount_price')
        ->paginate(12);

    return view('products.public', compact('products'));
}

}
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c
