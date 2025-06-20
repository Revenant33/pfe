@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">➕ Add New Product</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-300 rounded text-red-700">
            <strong>There were some issues:</strong>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded shadow space-y-5">
        @csrf

        <!-- Product Name -->
        <div>
            <label for="name" class="block font-medium">Product Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 dark:text-white focus:ring-primary focus:border-primary">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <!-- Product Category -->
        <div class="mt-4">
            <label for="category" class="block font-medium text-sm text-gray-700">Category</label>
            <select name="category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Select a Category --</option>
                <option value="Bakery & Pastries">Bakery & Pastries</option>
                <option value="Dairy Products">Dairy Products</option>
                <option value="Meat & Poultry">Meat & Poultry</option>
                <option value="Fish & Seafood">Fish & Seafood</option>
                <option value="Fruits & Vegetables">Fruits & Vegetables</option>
                <option value="Canned & Jarred Goods">Canned & Jarred Goods</option>
                <option value="Beverages">Beverages</option>
                <option value="Frozen Foods">Frozen Foods</option>
                <option value="Snacks & Confectionery">Snacks & Confectionery</option>
                <option value="Grains & Cereals">Grains & Cereals</option>
                <option value="Condiments & Sauces">Condiments & Sauces</option>
                <option value="Ready-to-Eat Meals">Ready-to-Eat Meals</option>
                <option value="Organic & Bio">Organic & Bio</option>
                <option value="Non-Food">Non-Food</option>
            </select>
            @error('category')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>


        <!-- Description -->
        <div>
            <label for="description" class="block font-medium">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 dark:text-white focus:ring-primary focus:border-primary">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Prices -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="original_price" class="block font-medium">Original Price</label>
                <input type="number" step="0.01" name="original_price" id="original_price" required 
                       value="{{ old('original_price') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:text-white focus:ring-primary focus:border-primary">
                @error('original_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="discount_price" class="block font-medium">Discounted Price</label>
                <input type="number" step="0.01" name="discount_price" id="discount_price" required 
                       value="{{ old('discount_price') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:text-white focus:ring-primary focus:border-primary">
                @error('discount_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Expiration Date -->
        <div>
            <label for="expiration_date" class="block font-medium">Expiration Date</label>
            <input type="date" name="expiration_date" id="expiration_date" required 
                   value="{{ old('expiration_date') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 dark:text-white focus:ring-primary focus:border-primary">
            @error('expiration_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image" class="block font-medium">Product Image</label>
            
            <!-- Image Preview -->
            <div id="image-preview-container" class="mt-2 hidden">
                <img id="image-preview" class="max-h-40 rounded-md shadow-sm">
            </div>

            <input type="file" name="image" id="image" accept="image/*"
                class="mt-1 block w-full rounded-md border-gray-300 dark:text-white focus:ring-primary focus:border-primary"
                onchange="previewImage(this)">
            
            @error('image') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
            @enderror
            
            <p class="text-sm text-gray-500 mt-1">Formats acceptés : JPG, JPEG, PNG, WEBP (Max 2MB)</p>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between pt-4">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-5 py-2 rounded">
                Add Product
            </button>
            <a href="{{ route('products.index') }}" class="block font-medium hover:underline">← Back to My Products</a>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        const previewContainer = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            previewContainer.classList.add('hidden');
        }
    }
</script>
@endsection
