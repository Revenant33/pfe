@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-extrabold mb-6 text-primary">Contact Us</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf

        <div>
            <label for="name" class="block font-semibold">Your Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-primary-light focus:border-primary">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block font-semibold">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-primary-light focus:border-primary">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="message" class="block font-semibold">Message</label>
            <textarea name="message" id="message" rows="5"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-primary-light focus:border-primary">{{ old('message') }}</textarea>
            @error('message')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-right">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-md shadow">
                Send Message
            </button>
        </div>
    </form>
</div>
@endsection
