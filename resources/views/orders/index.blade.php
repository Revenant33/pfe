@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>My Orders</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse ($orders as $order)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $order->product->name }}</h5>
                <p>{{ $order->product->description }}</p>
                <p>Paid: ${{ number_format($order->price_paid, 2) }}</p>
                <p>Ordered on: {{ $order->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>
    @empty
        <p>You haven't ordered anything yet.</p>
    @endforelse
</div>
@endsection
