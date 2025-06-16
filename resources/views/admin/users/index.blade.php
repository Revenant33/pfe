@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">User Management</h1>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }} @if(auth()->id() === $user->id) (You) @endif</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
               <td>
    <!-- Update Role -->
    <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="d-inline">
        @csrf
        <select name="role" onchange="this.form.submit()" class="form-select form-select-sm d-inline w-auto">
            <option value="buyer" {{ $user->role === 'buyer' ? 'selected' : '' }}>Buyer</option>
            <option value="seller" {{ $user->role === 'seller' ? 'selected' : '' }}>Seller</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </form>

    <!-- Toggle Admin -->
    @if($user->id !== auth()->id())
    <form action="{{ route('admin.users.toggleAdmin', $user) }}" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-sm btn-warning">{{ $user->role === 'admin' ? 'Demote' : 'Promote' }}</button>
    </form>
    @endif

    <!-- Delete User -->
    @if($user->id !== auth()->id())
    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">Delete</button>
    </form>
    @endif
   @if ($user->role === 'seller')
    <a href="{{ route('admin.users.products', $user) }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded shadow transition">
        🛍 View Products
    </a>
@elseif ($user->role === 'buyer')
    <a href="{{ route('admin.users.orders', $user) }}"
       class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded shadow transition">
        🧾 View Orders
    </a>
@endif

</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
