@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-extrabold text-primary mb-6">Contact Us</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
        @csrf
                
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700">Subject (Optional)</label>
            <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            @error('subject')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea name="message" id="message" rows="5" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('message') }}</textarea>
            @error('message')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit"
                class="bg-primary hover:bg-primary-dark text-white font-semibold px-4 py-2 rounded-md shadow">
                Send Message
            </button>
        </div>
    </form>
</div>
@endsection
