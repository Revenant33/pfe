@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Seller Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text">{{ $productCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Orders Received</h5>
                    <p class="card-text">{{ $orderCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text">${{ number_format($revenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Top-Selling Products</h4>
    <ul class="list-group mb-4">
        @forelse ($topProducts as $product)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $product->name }}
                <span class="badge bg-primary rounded-pill">{{ $product->times_sold }} sold</span>
            </li>
        @empty
            <li class="list-group-item">No products sold yet.</li>
        @endforelse
    </ul>

    <a href="{{ route('products.create') }}" class="btn btn-outline-primary">Add New Product</a>
</div>
@endsection

