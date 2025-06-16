@extends('layouts.app')

@section('content')
<div class="p-4">
    <h2 class="text-xl font-semibold  mb-4">
        🧑‍🍳 Seller Dashboard
    </h2>

    <p class="mb-4">Welcome back, <strong>{{ $user->name }}</strong>! Here's an overview of your shop:</p>

    <!-- Quick Stats -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-6">
        <h4 class="font-bold mb-3">📊 Quick Stats</h4>
        <ul class="list-disc list-inside text-sm space-y-1">
            <li><strong>Total Products:</strong> {{ $products->count() }}</li>
            <li><strong>Total Orders:</strong> {{ $orders->count() }}</li>
            <li><strong>Total Revenue:</strong> {{ number_format($orders->sum('total_price'), 2) }}DH</li>
        </ul>
    </div>

    <!-- Add Product Button -->
    <div class="mb-4">
        <a href="{{ route('products.create') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition">
            ➕ Add New Product
        </a>
    </div>

   <!-- Latest Products -->
<div class="mb-6">
    <h4 class="font-bold mb-2">🧁 Your Latest Products</h4>
    @forelse ($products->take(5) as $product)
        <div class="mb-2 text-sm text-gray-700 dark:text-gray-300">
            <strong>{{ $product->name }}</strong> — {{ number_format($product->discount_price, 2) }}DH
            <span class="text-xs text-gray-500">(Expires {{ \Carbon\Carbon::parse($product->expiration_date)->format('M d, Y') }})</span>
        </div>
    @empty
        <p class="text-sm text-gray-600">You haven’t added any products yet.</p>
    @endforelse
</div>

    </div>

    <!-- Best Selling -->
<div class="mb-6">
    <h4 class="font-bold mb-2">🏆 Top 5 Best-Selling Products</h4>
    @if ($topProducts->isNotEmpty())
        <ul class="list-inside list-disc text-sm space-y-1">
            @foreach ($topProducts as $product)
                <li>
                    <strong>{{ $product->name }}</strong> — Sold: {{ $product->times_sold }}
                    <span class="text-gray-500 text-xs">(Expires {{ \Carbon\Carbon::parse($product->expiration_date)->format('M d, Y') }})</span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-sm text-gray-500">No best-selling products yet.</p>
    @endif
</div>

   <!-- Expiring Soon -->
@if ($expiring->count())
    <div class="mb-6">
        <h4 class="font-bold text-red-600 mb-3">⚠️ Products Expiring Soon</h4>
        <ul class="space-y-3">
            @foreach ($expiring as $product)
                <li class="bg-red-100 dark:bg-red-900 text-sm p-3 rounded-md">
                    <div class="text-red-800 dark:text-red-300 font-semibold mb-1">
                        {{ $product->name }} — Expires {{ \Carbon\Carbon::parse($product->expiration_date)->format('M d, Y') }}
                    </div>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                            Delete
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endif


</div>
@endsection
