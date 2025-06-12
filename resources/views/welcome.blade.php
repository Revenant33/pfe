@extends('layouts.app')

@section('content')
<div style="background-image: url('/images/antigasp.jpg'); background-size: cover; background-position: center;" class="min-h-screen w-full">
    <div class="bg-black/60 w-full h-full">
        <div class="max-w-7xl mx-auto px-4 text-center text-white py-24">
            <h1 class="text-5xl font-bold mb-4 drop-shadow-lg">Welcome to DiscountBasket!</h1>
            <p class="text-xl mb-6 drop-shadow-lg">
                Save money and reduce waste by buying near-expiry food and discounted products from local sellers.
            </p>

            <div class="flex justify-center gap-4">
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
        </div>

        {{-- Section avec les 3 cartes --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 text-center text-white">
                <div class="grid md:grid-cols-3 gap-8 mt-12">
                    <div class="bg-white/80 p-6 rounded shadow text-black">
                        <h3 class="text-xl font-semibold text-primary mb-2">🛍 For Buyers</h3>
                        <p>Find great deals on products nearing expiration — fresh, safe, and affordable.</p>
                    </div>
                    <div class="bg-white/80 p-6 rounded shadow text-black">
                        <h3 class="text-xl font-semibold text-primary mb-2">🏪 For Sellers</h3>
                        <p>List your soon-to-expire products and recover losses by reaching new buyers.</p>
                    </div>
                    <div class="bg-white/80 p-6 rounded shadow text-black">
                        <h3 class="text-xl font-semibold text-primary mb-2">🌍 Save the Planet</h3>
                        <p>Join our mission to cut down food waste and create a sustainable community.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


