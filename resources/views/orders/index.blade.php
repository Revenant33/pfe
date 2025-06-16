@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-2xl font-bold mb-4">🧾 My Orders</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($orders as $timestamp => $groupedOrders)
        <div class="bg-white shadow rounded mb-6 p-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">
                Order placed on: {{ \Carbon\Carbon::parse($timestamp)->format('M d, Y H:i') }}
            </h2>
            <ul class="space-y-2">
                @foreach ($groupedOrders as $order)
                    <li class="border-b pb-2">
                        <p class="font-bold">{{ $order->product->name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->product->description }}</p>
                        <p>Quantity: {{ $order->quantity }}</p>
                        <p>Subtotal: ${{ number_format($order->total_price, 2) }}</p>
                    </li>
                @endforeach
            </ul>
            <p class="mt-2 font-semibold">
                Total: ${{ number_format($groupedOrders->sum('total_price'), 2) }}
            </p>
        </div>
    @empty
        <p class="text-gray-600">You haven't ordered anything yet.</p>
    @endforelse
</div>
@endsection
