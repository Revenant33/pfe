@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">📨 Contact Messages</h1>

    <!-- Filter/Search Form -->
    <form method="GET" class="mb-6 flex flex-wrap gap-4">
        <input type="text" name="email" placeholder="Filter by Email"
               value="{{ request('email') }}"
               class="border px-4 py-2 rounded-md shadow-sm w-64">

        <input type="date" name="date" value="{{ request('date') }}"
               class="border px-4 py-2 rounded-md shadow-sm">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">
            🔍 Filter
        </button>
        <a href="{{ route('admin.contact.index') }}" class="text-blue-500 underline mt-2">Clear Filters</a>
    </form>

    <!-- Messages Table -->
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Message</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                    <tr class="border-t align-top">
                        <td class="px-4 py-2">{{ $message->name }}</td>
                        <td class="px-4 py-2">{{ $message->email }}</td>
                        <td class="px-4 py-2 max-w-xs">
                            <div class="relative">
                                <span class="message-preview block">
                                    {{ Str::limit($message->message, 100) }}
                                </span>
                                @if(strlen($message->message) > 100)
                                    <span class="full-message hidden">{{ $message->message }}</span>
                                    <button type="button" class="toggle-message text-blue-600 underline text-sm mt-1">Show more</button>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-2">{{ $message->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.contact.destroy', $message) }}" method="POST"
                                  onsubmit="return confirm('Delete this message?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No messages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.toggle-message');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const preview = this.parentElement.querySelector('.message-preview');
                const full = this.parentElement.querySelector('.full-message');

                const showing = !full.classList.contains('hidden');

                full.classList.toggle('hidden');
                preview.classList.toggle('hidden');
                this.textContent = showing ? 'Show more' : 'Show less';
            });
        });
    });
</script>
@endpush
