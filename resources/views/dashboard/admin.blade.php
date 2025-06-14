@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-4xl font-extrabold text-primary mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white shadow-md p-5 rounded-lg text-center">
            <p class="text-sm text-gray-500">Total Users</p>
            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white shadow-md p-5 rounded-lg text-center">
            <p class="text-sm text-gray-500">Sellers</p>
            <p class="text-3xl font-bold">{{ $totalSellers }}</p>
        </div>
        <div class="bg-white shadow-md p-5 rounded-lg text-center">
            <p class="text-sm text-gray-500">Buyers</p>
            <p class="text-3xl font-bold">{{ $totalBuyers }}</p>
        </div>
        <div class="bg-white shadow-md p-5 rounded-lg text-center">
            <p class="text-sm text-gray-500">Admins</p>
            <p class="text-3xl font-bold">{{ $totalAdmins }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold">🧾 Total Orders</h2>
            <p class="text-2xl mt-2">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold">💰 Total Revenue</h2>
            <p class="text-2xl mt-2">${{ number_format($totalRevenue, 2) }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold">👤 Latest Users</h2>
            <ul class="mt-2">
                @foreach($latestUsers as $user)
                    <li>{{ $user->name }} – <small>{{ ucfirst($user->role) }}</small></li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow mb-10">
        <h2 class="text-lg font-semibold mb-3">🏆 Top-Selling Products</h2>
        @if($topProducts->count())
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="pb-2">Product</th>
                        <th class="pb-2">Seller</th>
                        <th class="pb-2">Times Sold</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->seller->name }}</td>
                        <td>{{ $product->times_sold }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No product sales data yet.</p>
        @endif
    </div>

    <div class="bg-white p-6 rounded shadow mb-10">
        <h2 class="text-lg font-semibold mb-3">⚠️ Expiring Soon (Next 3 Days)</h2>
        @if($expiringProducts->count())
            <ul class="list-disc ml-5">
                @foreach($expiringProducts as $product)
                    <li>{{ $product->name }} (Expires: {{ $product->expiration_date->format('Y-m-d') }})
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 text-sm ml-2" onclick="return confirm('Delete this expiring product?')">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No expiring products.</p>
        @endif
    </div>

    <div class="bg-white p-6 rounded shadow mb-10">
        <h2 class="text-lg font-semibold mb-3">📈 Revenue Over Time</h2>
        <canvas id="revenueChart" width="400" height="200"></canvas>
    </div>

    <div class="bg-white p-6 rounded shadow mb-10">
        <h2 class="text-lg font-semibold mb-3">👥 User Roles Distribution</h2>
        <canvas id="roleChart" width="300" height="300"></canvas>
    </div>

    <div class="flex flex-wrap gap-4">
        <a href="{{ route('admin.users.index') }}" class="bg-primary text-white px-5 py-3 rounded-md shadow hover:bg-primary-dark transition">
            ⚙️ Manage Users
        </a>
        <a href="{{ route('products.public') }}" class="bg-primary text-white px-5 py-3 rounded-md shadow hover:bg-primary-dark transition">
            🛒 View All Products
        </a>
        <a href="{{ route('admin.contact.index') }}" class="bg-primary text-white px-5 py-3 rounded-md shadow hover:bg-primary-dark transition">
    📬 View Contact Messages
    </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueLabels) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($revenueData) !!},
                borderColor: '#4CAF50',
                backgroundColor: 'rgba(76, 175, 80, 0.2)',
                fill: true,
                tension: 0.4
            }]
        }
    });

    const roleCtx = document.getElementById('roleChart').getContext('2d');
    const roleChart = new Chart(roleCtx, {
        type: 'doughnut',
        data: {
            labels: ['Admins', 'Sellers', 'Buyers'],
            datasets: [{
                data: [{{ $totalAdmins }}, {{ $totalSellers }}, {{ $totalBuyers }}],
                backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56'],
                hoverOffset: 4
            }]
        }
    });
</script>
@endsection
