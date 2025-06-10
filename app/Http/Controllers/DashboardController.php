<?php

namespace App\Http\Controllers;

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
        return view('dashboard.admin', compact('user'));
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
