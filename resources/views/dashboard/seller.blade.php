@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">🧑‍🍳 Seller Dashboard</h1>

    <p class="text-black mb-8">Welcome back, <strong>{{ $user->name }}</strong>! Here's an overview of your shop activity.</p>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
        <div class="bg-white shadow-md p-6 rounded-lg text-center">
            <p class="text-sm text-gray-500">Total Products</p>
            <p class="text-2xl font-bold">{{ $products->count() }}</p>
        </div>
        <div class="bg-white shadow-md p-6 rounded-lg text-center">
            <p class="text-sm text-gray-500">Total Orders</p>
            <p class="text-2xl font-bold">{{ $orders->count() }}</p>
        </div>
        <div class="bg-white shadow-md p-6 rounded-lg text-center">
            <p class="text-sm text-gray-500">Total Revenue</p>
            <p class="text-2xl font-bold">DH {{ number_format($orders->sum('total_price'), 2) }}</p>
        </div>
    </div>

    <!-- Add Product Button -->
    <div class="mb-8">
        <a href="{{ route('products.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-md shadow-md transition">
            ➕ Add New Product
        </a>
    </div>

        <!-- Latest Products -->
        <div class="bg-white p-6 rounded shadow mb-10">
            <h2 class="text-lg font-semibold mb-3">🧁 Latest Products</h2>
            @forelse ($products->take(5) as $product)
                <div class="flex justify-between text-sm py-2 border-b">
                    <span class="font-medium">{{ $product->name }}</span>
                    <span>DH {{ number_format($product->discount_price, 2) }}</span>
                    <span class="text-gray-500 text-xs">Expires {{ \Carbon\Carbon::parse($product->expiration_date)->format('M d, Y') }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-600">You haven’t added any products yet.</p>
            @endforelse
        </div>

    <!-- Best Selling Products -->
    <div class="bg-white p-6 rounded shadow mb-10">
        <h2 class="text-lg font-semibold mb-3">🏆 Top 5 Best-Selling Products</h2>
        @if ($topProducts->isNotEmpty())
            <ul class="text-sm space-y-2">
                @foreach ($topProducts as $product)
                    <li class="flex justify-between items-center">
                        <span class="font-medium">{{ $product->name }}</span>
                        <span class="text-gray-500 text-xs">Sold: {{ $product->times_sold }}</span>
                        <span class="text-xs text-gray-400">Expires {{ \Carbon\Carbon::parse($product->expiration_date)->format('M d, Y') }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-500">No best-selling products yet.</p>
        @endif
    </div>

    <!-- Expiring Soon -->
    @if ($expiring->count())
        <div class="bg-white p-6 rounded shadow mb-10">
            <h2 class="text-lg font-semibold mb-3 text-red-600">⚠️ Products Expiring Soon</h2>
            <ul class="space-y-4">
                @foreach ($expiring as $product)
                    <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-red-50 border border-red-200 p-4 rounded-md">
                        <div class="text-sm text-red-700 font-medium">
                            {{ $product->name }} — Expires {{ \Carbon\Carbon::parse($product->expiration_date)->format('M d, Y') }}
                        </div>
                        <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                              onsubmit="return confirm('Are you sure you want to delete this product?');"
                              class="mt-2 sm:mt-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">
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
