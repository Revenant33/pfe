@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-primary mb-6">🛒 Your Cart</h1>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="mb-4 text-red-600">{{ session('error') }}</div>
    @endif

    @if($cart->items->count())
        <table class="w-full table-auto mb-6 bg-white shadow-md rounded-lg">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="p-3">Product</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Quantity</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart->items as $item)
                    @php
                        $subtotal = $item->quantity * $item->product->discount_price;
                        $total += $subtotal;
                    @endphp
                    <tr class="border-b">
                        <td class="p-3">{{ $item->product->name }}</td>
                        <td class="p-3">${{ number_format($item->product->discount_price, 2) }}</td>
                        <td class="p-3">{{ $item->quantity }}</td>
                        <td class="p-3">${{ number_format($subtotal, 2) }}</td>
                        <td class="p-3">
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right mb-6">
            <p class="text-xl font-semibold">Total: ${{ number_format($total, 2) }}</p>
        </div>

        <form action="{{ route('cart.checkout') }}" method="POST" class="text-right">
            @csrf
            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded text-lg font-semibold">
                Confirm & Checkout
            </button>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
