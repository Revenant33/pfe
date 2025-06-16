@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-4xl font-extrabold text-primary mb-8">Admin Dashboard</h1>

    {{-- Top Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach ([
            ['label' => 'Total Users', 'value' => $totalUsers],
            ['label' => 'Sellers', 'value' => $totalSellers],
            ['label' => 'Buyers', 'value' => $totalBuyers],
            ['label' => 'Admins', 'value' => $totalAdmins],
        ] as $stat)
        <div class="bg-white shadow p-5 rounded-lg text-center">
            <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
            <p class="text-3xl font-bold">{{ $stat['value'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Orders + Revenue | Latest Users --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">🧾 Total Orders</h2>
            <p class="text-3xl">{{ $totalOrders }}</p>

            <h2 class="text-lg font-semibold mt-6 mb-2">💰 Total Revenue</h2>
            <p class="text-3xl">${{ number_format($totalRevenue, 2) }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">👤 Latest Users</h2>
            <ul class="space-y-2 text-sm">
                @foreach($latestUsers as $user)
                    <li>
                        <strong>{{ $user->name }}</strong> – <span class="text-gray-600">{{ ucfirst($user->role) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Top Products | Expiring Soon --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">🏆 Top-Selling Products</h2>
            @if($topProducts->count())
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 text-left">Product</th>
                            <th class="py-2 text-left">Seller</th>
                            <th class="py-2 text-left">Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $product)
                        <tr>
                            <td class="py-1">{{ $product->name }}</td>
                            <td class="py-1">{{ $product->seller->name ?? 'N/A' }}</td>
                            <td class="py-1">{{ $product->times_sold }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No top-selling products yet.</p>
            @endif
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">⚠️ Expiring Soon (Next 3 Days)</h2>
            @if($expiringProducts->count())
                <ul class="space-y-2 text-sm text-red-600">
                    @foreach($expiringProducts as $product)
                        <li class="flex justify-between items-center">
                            <span>{{ $product->name }} — {{ $product->expiration_date->format('Y-m-d') }}</span>
                            <form method="POST" action="{{ route('products.destroy', $product) }}">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this expiring product?')" class="text-red-500 text-xs">Delete</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No expiring products.</p>
            @endif
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">📈 Revenue Over Time</h2>
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">👥 User Roles Distribution</h2>
            <canvas id="roleChart" width="300" height="300"></canvas>
        </div>
    </div>

    {{-- Actions --}}
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

{{-- Charts --}}
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
