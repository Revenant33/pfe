@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">📦 My Products</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('products.create') }}" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded">
            ➕ Add New Product
        </a>
    </div>

    @if($products->count())
        <table class="w-full table-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow">
            <thead>
    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 text-left">
        <th class="px-4 py-2">Image</th>
        <th class="px-4 py-2">Name</th>
        <th class="px-4 py-2">Category</th> 
        <th class="px-4 py-2">Original Price</th>
        <th class="px-4 py-2">Discount Price</th>
        <th class="px-4 py-2">Expiration Date</th>
        <th class="px-4 py-2">Actions</th>
    </tr>
</thead>
<tbody>
    @foreach($products as $product)
        <tr class="border-t dark:border-gray-600">
            <td class="px-4 py-2">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="w-12 h-12 object-cover rounded">
                @else
                    <span class="text-gray-400">No image</span>
                @endif
            </td>
            <td class="px-4 py-2">{{ $product->name }}</td>
            <td class="px-4 py-2">{{ $product->category ?? 'N/A' }}</td>
            <td class="px-4 py-2">DH {{ number_format($product->original_price, 2) }}</td>
            <td class="px-4 py-2 text-green-600">DH {{ number_format($product->discount_price, 2) }}</td>
            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($product->expiration_date)->toFormattedDateString() }}</td>
            <td class="px-4 py-2">
    <div class="flex flex-wrap gap-2">
        <!-- Edit Button -->
         
        <a href="{{ route('products.edit', $product) }}"
           class="bg-green-500 hover:bg-green-600  px-3 py-1 rounded text-sm shadow transition">
            ✏️ Edit
        </a>

        <!-- Delete Button -->
        <form method="POST" action="{{ route('products.destroy', $product) }}"
              onsubmit="return confirm('Delete this product?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm shadow transition">
                🗑️ Delete
            </button>
        </form>

        <!-- History Button -->
        <a href="{{ route('products.orders', $product) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm shadow transition">
            📊 History
        </a>
    </div>
</td>

        </tr>
    @endforeach
</tbody>

        </table>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @else
        <p class="text-gray-600 dark:text-gray-300">You have no products listed.</p>
    @endif
</div>
@endsection
