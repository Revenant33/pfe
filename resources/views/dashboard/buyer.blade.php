@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">👤 Welcome, {{ $user->name }}!</h2>

    <div class="row mb-4">
        <!-- Quick Stats -->
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">🧾 Total Orders</h5>
                    <p class="card-text h4">{{ $orderCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">💸 Total Spent</h5>
                    <p class="card-text h4">{{ number_format($totalSpent, 2) }}DH</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            🛒 Recent Orders
        </div>
        <div class="card-body">
 @forelse ($orders as $order)
        <div class="mb-3 border-bottom pb-2">
            <img src="{{ asset('storage/' . $order->product->image) }}"
     alt="{{ $order->product->name }}"
     class="rounded me-3"
     style="width: 80px; height: 80px; object-fit: cover;">

        <h5>{{ $order->product->name }}</h5>
        <p>
            Quantity: {{ $order->quantity }} <br>
            Total: {{ number_format($order->total_price, 2) }}DH
         </p>
        </div>
    @empty
    <p class="text-muted">You haven’t ordered anything yet.</p>
@endforelse

        
    <div class="mt-4">
    <a href="{{ route('products.public') }}" class="btn btn-primary">
        🔍 Browse More Products
    </a>
    </div>
    </div>
</div>
@endsection
