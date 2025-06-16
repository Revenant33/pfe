@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-primary mb-6">🛒 Your Cart</h1>

    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300 shadow-sm">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 border border-red-300 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if($cart->items->count())
        <div class="overflow-x-auto">
            <table class="w-full table-auto mb-6 bg-white shadow-md rounded-lg">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="p-3 text-left">Product</th>
                        <th class="p-3 text-left">Price</th>
                        <th class="p-3 text-left">Quantity</th>
                        <th class="p-3 text-left">Total</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @php $total = 0; @endphp
                    @foreach($cart->items as $item)
                        @php
                            $subtotal = $item->quantity * $item->product->discount_price;
                            $total += $subtotal;
                        @endphp
                        <tr class="border-t">
                            <td class="p-3">{{ $item->product->name }}</td>
                            <td class="p-3">${{ number_format($item->product->discount_price, 2) }}</td>
                            <td class="p-3">{{ $item->quantity }}</td>
                            <td class="p-3">${{ number_format($subtotal, 2) }}</td>
                            <td class="p-3">
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-1 rounded">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            

            <div class="text-xl font-bold text-gray-800 dark:text-white">
                Total: ${{ number_format($total, 2) }}
            </div>
        </div>

        <form action="{{ route('cart.checkout') }}" method="POST" class="text-right">
            @csrf
            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded text-lg font-semibold shadow">
                ✅ Confirm & Checkout
            </button>
        </form>
    @else
        <div class="text-center py-12 text-gray-600 dark:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7a1 1 0 00.9 1.5h10.9a1 1 0 00.9-1.5L17 13M7 13H5.4m1.6 0l-1.35 2.7M17 13l1.35 2.7M9 21h.01M15 21h.01" />
            </svg>
            <h2 class="text-lg font-semibold">Your cart is empty.</h2>
            <p class="text-sm">Start adding discounted deals now!</p>
            <a href="{{ route('products.public') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                🛍 Browse Products
            </a>
        </div>
    @endif
</div>
@endsection
