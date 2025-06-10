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

    <form method="POST" action="{{ route('products.store') }}" class="bg-white dark:bg-gray-800 p-6 rounded shadow space-y-5">
        @csrf

        <div>
            <label for="name" class="block font-medium ">Product Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                   class="mt-1 block w-full rounded-md border-gray-300  dark:text-white focus:ring-primary focus:border-primary">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block font-medium ">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300  dark:text-white focus:ring-primary focus:border-primary">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="original_price" class="block font-medium ">Original Price</label>
                <input type="number" step="0.01" name="original_price" id="original_price" required value="{{ old('original_price') }}"
                       class="mt-1 block w-full rounded-md border-gray-300  dark:text-white focus:ring-primary focus:border-primary">
                @error('original_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="discount_price" class="block font-medium ">Discounted Price</label>
                <input type="number" step="0.01" name="discount_price" id="discount_price" required value="{{ old('discount_price') }}"
                       class="mt-1 block w-full rounded-md border-gray-300  dark:text-white focus:ring-primary focus:border-primary">
                @error('discount_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="expiration_date" class="block font-medium ">Expiration Date</label>
            <input type="date" name="expiration_date" id="expiration_date" required value="{{ old('expiration_date') }}"
                   class="mt-1 block w-full rounded-md border-gray-300  dark:text-white focus:ring-primary focus:border-primary">
            @error('expiration_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between pt-4">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-5 py-2 rounded">
                Add Product
            </button>
            <a href="{{ route('products.index') }}" class="block font-medium hover:underline ">← Back to My Products</a>
        </div>
    </form>
</div>
@endsection
