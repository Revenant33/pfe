@extends('layouts.app')

@section('content')
<div class="bg-background py-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-primary mb-4">Welcome to ExpiryProducts!!</h1>
        <p class="text-lg text-foreground mb-6">
            Save money and reduce waste by buying near-expiry food and discounted products from local sellers.
        </p>

        <div class="flex justify-center gap-4 mb-8">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-primary text-white px-6 py-3 rounded-md shadow hover:bg-primary-dark transition">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-primary text-white px-6 py-3 rounded-md shadow hover:bg-primary-dark transition">
                    Get Started 
                </a>
                <a href="{{ route('login') }}" class="bg-white text-primary border border-primary px-6 py-3 rounded-md hover:bg-primary hover:text-white transition">
                    Log In
                </a>
            @endauth
        </div>

        <div class="grid md:grid-cols-3 gap-8 mt-12">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold text-primary mb-2">🛍 For Buyers</h3>
                <p>Find great deals on products nearing expiration — fresh, safe, and affordable.</p>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold text-primary mb-2">🏪 For Sellers</h3>
                <p>List your soon-to-expire products and recover losses by reaching new buyers.</p>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold text-primary mb-2">🌍 Save the Planet</h3>
                <p>Join our mission to cut down food waste and create a sustainable community.</p>
            </div>
        </div>
    </div>
</div>
@endsection
