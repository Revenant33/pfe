@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-6 text-primary">👥 User Management</h1>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Registered</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-800">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2">
                            {{ $user->name }}
                            @if(auth()->id() === $user->id)
                                <span class="text-xs text-gray-400">(You)</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ ucfirst($user->role) }}</td>
                        <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 space-y-1 md:space-y-0 md:space-x-2 flex flex-wrap items-center">

                            {{-- Role Dropdown --}}
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                                @csrf
                                <select name="role" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm w-48">
                                    <option value="buyer" {{ $user->role === 'buyer' ? 'selected' : '' }}>Buyer</option>
                                    <option value="seller" {{ $user->role === 'seller' ? 'selected' : '' }}>Seller</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>

                            {{-- Promote/Demote --}}
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggleAdmin', $user) }}" method="POST">
                                    @csrf
                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                        {{ $user->role === 'admin' ? 'Demote' : 'Promote' }}
                                    </button>
                                </form>
                            @endif

                            {{-- Delete --}}
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            @endif

                            {{-- View Orders/Products --}}
                            @if ($user->role === 'seller')
                                <a href="{{ route('admin.users.products', $user) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                    🛍 Products
                                </a>
                            @elseif ($user->role === 'buyer')
                                <a href="{{ route('admin.users.orders', $user) }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                                    🧾 Orders
                                </a>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
