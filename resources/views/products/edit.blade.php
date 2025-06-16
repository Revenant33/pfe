@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">✏️ Edit Product</h1>

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

    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-5">
        @csrf
        @method('PUT')

        <!-- Current Image Preview -->
        <div>
            <label class="block font-medium">Current Image</label>
            @if($product->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$product->image) }}" 
                         alt="Current product image" 
                         class="max-h-40 rounded-md shadow-sm">
                    <label class="inline-flex items-center mt-2">
                        <input type="checkbox" name="remove_image" class="rounded">
                        <span class="ml-2">Remove current image</span>
                    </label>
                </div>
            @else
                <p class="text-gray-500 mt-1">No image currently set</p>
            @endif
        </div>

        <!-- New Image Upload -->
        <div>
            <label for="image" class="block font-medium">Update Image</label>
            <div id="image-preview-container" class="mt-2 hidden">
                <img id="image-preview" class="max-h-40 rounded-md shadow-sm">
            </div>
            <input type="file" name="image" id="image" accept="image/*"
                   class="mt-1 block w-full rounded-md border-gray-300 focus:ring-primary focus:border-primary"
                   onchange="previewImage(this)">
            @error('image') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
            @enderror
            <p class="text-sm text-gray-500 mt-1">Formats: JPG, JPEG, PNG, WEBP (Max 2MB)</p>
        </div>

        <!-- Other Fields -->
        <div class="mb-3">
            <label class="block font-medium">Name</label>
            <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300"
                   value="{{ old('name', $product->name) }}" required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <!-- Category -->
        <div class="mb-4">
    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
    <select id="category" name="category" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        @php
            $categories = ['Fruits & Vegetables', 'Dairy & Eggs', 'Meat & Fish', 'Bakery', 'Snacks', 'Beverages', 'Frozen', 'Canned Goods'];
        @endphp
        @foreach ($categories as $cat)
            <option value="{{ $cat }}" {{ $product->category === $cat ? 'selected' : '' }}>
                {{ $cat }}
            </option>
        @endforeach
        </select>
     </div>


        <div class="mb-3">
            <label class="block font-medium">Description</label>
            <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('description', $product->description) }}</textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium">Original Price</label>
                <input type="number" step="0.01" name="original_price" 
                       class="mt-1 block w-full rounded-md border-gray-300"
                       value="{{ old('original_price', $product->original_price) }}" required>
                @error('original_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-medium">Discount Price</label>
                <input type="number" step="0.01" name="discount_price" 
                       class="mt-1 block w-full rounded-md border-gray-300"
                       value="{{ old('discount_price', $product->discount_price) }}" required>
                @error('discount_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Expiration Date</label>
            <input type="date" name="expiration_date" 
                   class="mt-1 block w-full rounded-md border-gray-300"
                   value="{{ old('expiration_date', $product->expiration_date->format('Y-m-d')) }}" required>
            @error('expiration_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between pt-4">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-5 py-2 rounded">
                Update Product
            </button>
            <a href="{{ route('products.index') }}" class="block font-medium hover:underline">← Back to Products</a>
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
