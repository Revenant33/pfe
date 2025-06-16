<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

class UserManagementController extends Controller
{
    public function index()
    {
        // Only allow admin access
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }
    public function updateRole(Request $request, User $user)
{
    if (Auth::user()->role !== 'admin') {
        abort(403);
    }

    $request->validate([
        'role' => 'required|in:admin,seller,buyer',
    ]);

    $user->role = $request->role;
    $user->save();

    return back()->with('success', 'User role updated.');
}

public function toggleAdmin(User $user)
{
    if (Auth::user()->role !== 'admin') {
        abort(403);
    }

    $user->role = $user->role === 'admin' ? 'buyer' : 'admin';
    $user->save();

    return back()->with('success', 'User admin status toggled.');
}

public function destroy(User $user)
{
    if (Auth::user()->role !== 'admin') {
        abort(403);
    }

    // Prevent deleting self
    if ($user->id === Auth::id()) {
        return back()->with('error', 'You cannot delete yourself.');
    }

    $user->delete();

    return back()->with('success', 'User deleted.');
}
    public function viewSellerProducts(User $user)
    {
        if ($user->role !== 'seller') {
            abort(403);
        }

        $products = Product::where('seller_id', $user->id)->latest()->paginate(10);
        return view('admin.users.seller-products', compact('user', 'products'));
    }
    public function viewBuyerOrders(User $user)
    {
        if ($user->role !== 'buyer') {
            abort(403);
        }

        $orders = Order::where('user_id', $user->id)->with('product')->latest()->paginate(10);
        return view('admin.users.buyer-orders', compact('user', 'orders'));
    }

}
