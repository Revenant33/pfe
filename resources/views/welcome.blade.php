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
        <!-- FAQ section -->
                <div class="max-w-5xl mx-auto py-12 px-4">
        <h2 class="text-3xl font-bold text-primary mb-8 text-center">Frequently Asked Questions</h2>

        <div class="space-y-6">
            <div>
                <h3 class="text-xl font-semibold">🛒 How do I buy a product?</h3>
                <p class="text-gray-700">Browse discounted products on the homepage. When you find an item you like, click "Add to Cart" and proceed to the cart page when you're ready to confirm your order.</p>
            </div>

            <div>
                <h3 class="text-xl font-semibold">👨‍🍳 I'm a seller, how do I list my items?</h3>
                <p class="text-gray-700">Register as a seller, then navigate to "Add Product" in your dashboard to list items with a name, description, price, discount, and expiration date.</p>
            </div>

            <div>
                <h3 class="text-xl font-semibold">🧾 Where can I see my orders?</h3>
                <p class="text-gray-700">Buyers can view their past and current orders in the "My Orders" section of their dashboard.</p>
            </div>

            <div>
                <h3 class="text-xl font-semibold">🔒 Do I need an account?</h3>
                <p class="text-gray-700">Yes, you need to create a free account to either buy or sell on our platform. You can register as a buyer or seller when signing up.</p>
            </div>

            <div>
                <h3 class="text-xl font-semibold">📦 What happens to expired products?</h3>
                <p class="text-gray-700">Products are automatically hidden when expired. Admins can also manually review and delete items that are close to expiration.</p>
            </div>
        </div>
    </div>
    <!-- Contact us Section -->
        <div class="max-w-5xl mx-auto py-12 px-4">
    <h2 class="text-3xl font-bold text-primary mb-6 text-center">Contact Us</h2>
    <p class="text-center text-gray-600 mb-8">
        Have a question or suggestion? We'd love to hear from you.
    </p>

    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4 max-w-xl mx-auto">
        @csrf
        <div>
            <label for="name" class="block font-semibold text-gray-700">Name</label>
            <input type="text" id="name" name="name" required class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div>
            <label for="email" class="block font-semibold text-gray-700">Email</label>
            <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div>
            <label for="message" class="block font-semibold text-gray-700">Message</label>
            <textarea id="message" name="message" rows="5" required class="w-full border border-gray-300 rounded px-4 py-2"></textarea>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded hover:bg-primary-dark transition">
                Send Message
            </button>
        </div>
    </form>
</div>

    </div>
</div>
@endsection
