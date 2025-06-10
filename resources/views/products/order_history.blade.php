@extends('layouts.app')

@section('content')
<div class="p-4">
    <h2 class="text-xl font-bold mb-4">
        📦 Order History for "{{ $product->name }}"
    </h2>

    @if ($orders->isEmpty())
        <p>No orders have been placed for this product yet.</p>
    @else
        <table class="table-auto w-full bg-white shadow rounded mb-4">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Buyer</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Total Price</th>
                    <th class="px-4 py-2">Ordered At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $order->user->name }}</td>
                        <td class="px-4 py-2">{{ $order->quantity }}</td>
                        <td class="px-4 py-2">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->toDayDateTimeString() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('dashboard') }}" class="inline-block mt-2 text-blue-600 hover:underline">
        ← Back to Dashboard
    </a>
</div>
@endsection
