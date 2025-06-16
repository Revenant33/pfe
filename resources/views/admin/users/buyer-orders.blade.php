@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">🛒 Orders for {{ $user->name }}</h1>

    @if ($orders->isEmpty())
        <p class="text-gray-600">This user has no orders.</p>
    @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">Product</th>
                        <th class="px-4 py-3 text-left">Category</th>
                        <th class="px-4 py-3 text-left">Price</th>
                        <th class="px-4 py-3 text-left">Quantity</th>
                        <th class="px-4 py-3 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">
                                {{ $order->product->name ?? '❌ Deleted Product' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $order->product->category ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-2 text-green-600">
                                ${{ number_format($order->price, 2) }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $order->quantity }}
                            </td>
                            <td class="px-4 py-2 text-gray-500">
                                {{ $order->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
