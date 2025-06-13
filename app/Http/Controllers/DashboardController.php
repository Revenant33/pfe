<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
    $totalUsers = \App\Models\User::count();
    $totalSellers = \App\Models\User::where('role', 'seller')->count();
    $totalBuyers = \App\Models\User::where('role', 'buyer')->count();
    $totalAdmins = \App\Models\User::where('role', 'admin')->count();
    $totalOrders = Order::count();
    $totalRevenue = Order::sum('total_price');
    $latestUsers = \App\Models\User::latest()->take(5)->get();
    $topProducts = Product::orderByDesc('times_sold')->take(5)->with('seller')->get();
    $expiringProducts = Product::where('expiration_date', '<=', now()->addDays(3))->get();
    $revenueLabels = [];
    $revenueData = [];

    foreach (range(6, 0) as $daysAgo) {
        $date = Carbon::now()->subDays($daysAgo)->format('Y-m-d');
        $label = Carbon::now()->subDays($daysAgo)->format('M d');
        $revenue = Order::whereDate('created_at', $date)->sum('total_price');

        $revenueLabels[] = $label;
        $revenueData[] = $revenue;
    }

    return view('dashboard.admin', compact(   'user', 'totalUsers', 'totalSellers', 'totalBuyers', 'totalAdmins'
                                             ,'totalOrders', 'totalRevenue', 'latestUsers', 'topProducts'
                                             ,'latestUsers','revenueLabels','revenueData','expiringProducts'));
    }

    if ($user->role === 'seller') {
        $products = $user->products()->latest()->take(5)->get();
        $expiring = $user->products()->whereDate('expiration_date', '<=', now()->addDays(3))->get();

        $orders = \App\Models\Order::whereHas('product', function ($q) use ($user) {
            $q->where('seller_id', $user->id);
        })->get();

        $topProducts = $user->products()
            ->where('times_sold', '>', 0)
            ->orderByDesc('times_sold')
            ->take(5)
            ->get();

        return view('dashboard.seller', compact(
            'user', 'products', 'expiring', 'orders', 'topProducts'
        ));
        

    }
    if ($user->role === 'buyer') {
            $orders = $user->orders()->with('product')->latest()->take(5)->get();
            $orderCount = $user->orders()->count();
            $totalSpent = $user->orders()->sum('total_price');

        return view('dashboard.buyer', compact('user', 'orders', 'orderCount', 'totalSpent'));
        }

    return view('dashboard');
}

}
