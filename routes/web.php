<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::view('/about', 'about')->name('about');
Route::get('/products/{product}/orders', [App\Http\Controllers\ProductController::class, 'orderHistory'])
    ->middleware(['auth'])
    ->name('products.orders');

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{product}', [OrderController::class, 'store'])->name('orders.store');
});

Route::get('/', function () {
    return view('welcome');
<<<<<<< HEAD
})->name('home');

=======
});
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c
Route::get('/browse', [ProductController::class, 'publicIndex'])->name('products.public');
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');    

Route::middleware('auth')->group(function () {

    //Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/test-products', function () {
    $user = Auth::user();

    if ($user) {
        return $user->products;
    } else {
        return 'No user is logged in.';
    }
    
});

require __DIR__.'/auth.php';
Route::middleware('auth')->group(function () {
    Route::get('/my-profile', [ProfileController::class, 'show'])->name('profile.custom');
});
Route::get('/profile', function () {
    return redirect('/my-profile');
});
use App\Http\Controllers\Admin\UserManagementController;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::post('/admin/users/{user}/toggle-admin', [UserManagementController::class, 'toggleAdmin'])->name('admin.users.toggleAdmin');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
});

