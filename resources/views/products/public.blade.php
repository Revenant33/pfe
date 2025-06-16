@extends('layouts.app')

@section('content')
<div class="container py-6 mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-white">Discounted Products</h1>
    @if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300 shadow-sm">
        {{ session('success') }}
    </div>
@endif
    <form method="GET" class="mb-6 flex flex-wrap gap-4 items-center">
    <<form method="GET" class="mb-6 flex flex-wrap items-end gap-4 bg-white p-4 rounded-lg shadow-sm border">

    <!-- Search -->
    <div class="flex flex-col">
        <label for="search" class="text-sm font-medium text-gray-700 mb-1">Search</label>
        <input type="text" id="search" name="search" placeholder="Product name..." 
               value="{{ request('search') }}"
               class="px-4 py-2 border rounded-md shadow-sm w-64 focus:ring focus:ring-blue-200">
    </div>

    <!-- Category -->
    <div class="flex flex-col">
        <label for="category" class="text-sm font-medium text-gray-700 mb-1">Category</label>
        <select id="category" name="category" 
                class="px-4 py-2 border rounded-md shadow-sm w-48 bg-white focus:ring focus:ring-blue-200">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                    {{ ucfirst($cat) }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Min Price -->
    <div class="flex flex-col">
        <label for="min_price" class="text-sm font-medium text-gray-700 mb-1">Min Price</label>
        <input type="number" step="0.01" id="min_price" name="min_price" placeholder="0.00"
               value="{{ request('min_price') }}"
               class="px-4 py-2 border rounded-md shadow-sm w-32 focus:ring focus:ring-blue-200">
    </div>

    <!-- Max Price -->
    <div class="flex flex-col">
        <label for="max_price" class="text-sm font-medium text-gray-700 mb-1">Max Price</label>
        <input type="number" step="0.01" id="max_price" name="max_price" placeholder="100.00"
               value="{{ request('max_price') }}"
               class="px-4 py-2 border rounded-md shadow-sm w-32 focus:ring focus:ring-blue-200">
    </div>

    <!-- Buttons -->
    <div class="flex gap-2 mt-6">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
            🔍 Filter
        </button>
        <a href="{{ route('products.public') }}"
           class="text-blue-600 hover:underline text-sm mt-2 block">
            Clear Filters
        </a>
    </div>
</form>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                <!-- Product Image -->
                <div class="h-48 overflow-hidden bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}"
                             class="object-cover h-full w-full transition-transform duration-500 hover:scale-105">
                    @else
                        <div class="text-gray-400 dark:text-gray-500 p-4 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm mt-2 block">No image available</span>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="p-4 flex-grow flex flex-col">
                    <div class="flex-grow">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-black mb-1 line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                        
                        <!-- Pricing -->
                        <div class="mb-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400 text-sm line-through mr-2">
                                        DH {{ number_format($product->original_price, 2) }}
                                    </span>
                                    <span class="font-bold text-lg text-primary dark:text-primary-300">
                                        DH {{ number_format($product->discount_price, 2) }}
                                    </span>
                                </div>
                                <span class="text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded">
                                    {{ round(100 - ($product->discount_price / $product->original_price * 100)) }}% OFF
                                </span>
                            </div>
                        </div>
                        
                        <!-- Expiration -->
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Expires: {{ $product->expiration_date->format('M j, Y') }}
                        </div>
                    </div>

                            @auth
    @if(Auth::user()->role === 'admin')
        <div class="mt-auto flex flex-col gap-2">
            <!-- Modal Toggle Button -->
<div x-data="{ open: false }">
    <button 
        @click="open = true"
        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-sm font-medium transition">
        View Seller Info
    </button>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-gray bg-opacity-50">


        <div @click.away="open = false" class="bg-white p-6 rounded-lg shadow-xl w-[90%] max-w-md">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center gap-2">
                👤 Seller Information
            </h2>

            <div class="space-y-2 text-sm text-gray-700">
                <p><strong>Name:</strong> {{ $product->seller->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $product->seller->email ?? 'N/A' }}</p>
                <p><strong>Role:</strong> {{ $product->seller->role ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $product->seller->phone ?? 'N/A' }}</p>
                <p><strong>City:</strong> {{ $product->seller->ville ?? 'N/A' }}</p>
            
            </div>
            @if ($product->seller->role === 'seller')
    <a href="{{ route('admin.users.products', $product->seller->id) }}"
       class="mt-3 inline-block bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition text-sm">
        View Seller's Products
    </a>
@endif
            <div class="mt-6 text-right">
                <button @click="open = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>


            <!-- Delete Product -->
            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm font-medium transition"
                        onclick="return confirm('Are you sure you want to delete this product?');">
                    Delete Product
                </button>
            </form>
        </div>
            @else
        <!-- Order Form for Buyers/Sellers -->
        <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-auto">
            @csrf
            <div class="flex items-center gap-2">
                <input type="number" name="quantity" value="1" min="1" 
                    class="w-16 px-2 py-1 border rounded-md ">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors flex-grow">
                    Add to Cart
                </button>
            </div>
        </form>
             @endif
            @endauth


                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-600 dark:text-gray-300">No discounted products available</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Check back later for new deals</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
