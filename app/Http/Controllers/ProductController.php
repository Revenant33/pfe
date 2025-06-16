<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'discount_price' => 'required|numeric|min:0|lt:original_price',
            'expiration_date' => 'required|date|after:today',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
            
        $data = $request->only([
            'name', 'description', 'original_price', 
            'discount_price', 'expiration_date','category'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Auth::user()->products()->create($data);

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
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'discount_price' => 'required|numeric|min:0|lt:original_price',
            'expiration_date' => 'required|date|after:today',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'name', 'description', 'original_price', 
            'discount_price', 'expiration_date','category'
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Delete a product
    public function destroy(Product $product)
{
    $user = Auth::user();

    // If the user is neither the product owner nor an admin, deny access
    if ($user->id !== $product->seller_id && $user->role !== 'admin') {
        abort(403, 'You are not authorized to delete this product.');
    }

    // Delete image if exists
    if ($product->image && Storage::disk('public')->exists($product->image)) {
        Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return redirect()->back()->with('success', 'Product deleted successfully.');
}


  public function publicIndex(Request $request)
{
    // Start with the query builder
    $query = Product::with('seller')
        ->whereDate('expiration_date', '>', now());

    // Apply filters if present
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }
    
        if ($request->filled('min_price')) {
        $query->where('discount_price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('discount_price', '<=', $request->max_price);
    }
    if ($request->filled('ville')) {
    $query->whereHas('seller', function ($q) use ($request) {
        $q->where('ville', $request->ville);
    });
    }


    // Execute query with sorting and pagination
    $products = $query->orderBy('discount_price')->paginate(12);

    // Get unique categories for the filter dropdown
   $categories = Product::select('category')
    ->whereNotNull('category')
    ->where('category', '!=', '')
    ->distinct()
    ->pluck('category');
    // Get unique cities (from sellers)
    $villes = \App\Models\User::whereNotNull('ville')
            ->where('ville', '!=', '')
            ->distinct()
            ->pluck('ville');


    return view('products.public', compact('products', 'categories', 'villes'));
}
}
