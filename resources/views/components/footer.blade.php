<footer class="bg-white border-t mt-12">
  <div class="min-h-screen py-16 bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/images/antigasp.jpg')">  
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Contact Us Form -->
            <div>
                <h2 class="text-xl font-bold text-primary mb-4">Contact Us</h2>
                <p class="text-blue-600 mb-4">Have a question or suggestion? We'd love to hear from you.</p>
                @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-300 rounded">
                {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block font-semibold text-orange-700">Name</label>
                        <input type="text" id="name" name="name" required class="w-full border border-gray-300 rounded px-4 py-2">
                    </div>

                    <div>
                        <label for="email" class="block font-semibold text-orange-700">Email</label>
                        <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded px-4 py-2">
                    </div>

                    <div>
                        <label for="message" class="block font-semibold text-orange-700">Message</label>
                        <textarea id="message" name="message" rows="4" required class="w-full border border-gray-300 rounded px-4 py-2"></textarea>
                    </div>

                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded hover:bg-primary-dark transition">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Optional: Add quick links or contact details -->
            <div>
                <h2 class="text-xl font-bold text-primary mb-4">Quick Links</h2>
                <ul class="text-orange-600 space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:underline">About</a></li>
                    <li><a href="{{ route('products.public') }}" class="hover:underline">Browse Products</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-8 text-center text-blue-500 text-sm">
            &copy; {{ date('Y') }} ExpiryProducts. All rights reserved.
        </div>
    </div>
  </div>
</footer>
