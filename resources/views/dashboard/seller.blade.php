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
            <li><strong>Total Revenue:</strong> ${{ number_format($orders->sum('total_price'), 2) }}</li>
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
        @forelse ($products as $product)
    <div class="mb-2">
        <strong>{{ $product->name }}</strong> - ${{ number_format($product->discount_price, 2) }}  
        <small>(Expires: {{ \Carbon\Carbon::parse($product->expiration_date)->toFormattedDateString() }})</small><br>
        <a href="{{ route('products.orders', $product) }}" class="text-blue-600 text-sm hover:underline">
            🧾 View Order History
        </a>
    </div>
@empty
    <p>You haven’t added any products yet.</p>
@endforelse
    </div>

    <!-- Best Selling -->
    <div class="mb-6">
        <h4 class="font-bold mb-2">🏆 Top 5 Best-Selling Products</h4>
        @if ($topProducts->count())
            <ul class="list-inside list-disc text-sm space-y-1">
                @foreach ($topProducts as $product)
                    <li>{{ $product->name }} — Sold: {{ $product->times_sold }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-500">No products sold yet.</p>
        @endif
    </div>

    <!-- Expiring Soon -->
    @if ($expiring->count())
        <div class="mb-6">
            <h4 class="font-bold text-red-600 mb-2">⚠️ Products Expiring Soon</h4>
            <ul class="list-inside list-disc text-sm text-red-600">
                @foreach ($expiring as $product)
                    <li>{{ $product->name }} — Expires {{ \Carbon\Carbon::parse($product->expiration_date)->toFormattedDateString() }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
