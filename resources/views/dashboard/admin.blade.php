<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="p-4">
        <p>Welcome back, Admin {{ $user->name }}!</p>
        <p>You can manage users and monitor system activities.</p>

        <a href="{{ route('admin.users.index') }}" class="btn btn-primary mt-3">Manage Users</a>
    </div>
</x-app-layout>
