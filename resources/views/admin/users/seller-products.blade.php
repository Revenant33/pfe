@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">🛍 Products by {{ $user->name }}</h1>
    

<form method="GET" class="mb-6 flex gap-4">
    <input type="text" name="search" value="{{ request('search') }}" 
           placeholder="Search by name or category"
           class="border px-4 py-2 rounded-md shadow-sm w-64">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Search</button>
</form>

    @if($products->isEmpty())
        <p class="text-gray-600">This seller has not listed any products.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($products as $product)
            
                <div class="bg-white shadow rounded p-4">
                     @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                 class="w-full h-40 object-cover rounded mb-3">
        @else
            <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500 rounded mb-3">
                No image
            </div>
        @endif
                    <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                     <p class="text-sm text-blue-600 dark:text-blue-300 mb-1">
                 📦 Category: <span class="font-semibold">{{ $product->category ?? 'N/A' }}</span>
            </p>
                    <p class="text-gray-600 text-sm">{{ $product->description }}</p>
                    <div class="mt-2 text-sm text-gray-700">
                        <p><strong>Price:</strong> ${{ number_format($product->discount_price, 2) }}</p>
                        <p><strong>Expires:</strong> {{ $product->expiration_date->format('M d, Y') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
