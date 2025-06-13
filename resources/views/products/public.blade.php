@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Discounted Products</h1>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p><strong>Original:</strong> ${{ number_format($product->original_price, 2) }}</p>
                        <p><strong>Discount:</strong> ${{ number_format($product->discount_price, 2) }}</p>
                        <p><strong>Expires:</strong> {{ \Carbon\Carbon::parse($product->expiration_date)->toFormattedDateString() }}</p>

                        <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf
                        <div class="mb-2">
                            <input type="number" name="quantity" value="1" min="1" class="form-control form-control-sm" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                    </form>




                    </div>
                </div>
            </div>
        @empty
            <p>No discounted products available right now.</p>
        @endforelse
    </div>

    {{ $products->links() }}
</div>
@endsection
