<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;


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
})->name('home');


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
    Route::get('/admin/contact-messages', [ContactController::class, 'viewMessages'])->name('admin.contact.index');
    Route::delete('/admin/contact-messages/{id}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');
    Route::get('/admin/users/{user}/products', [UserManagementController::class, 'viewSellerProducts'])->name('admin.users.products');
    Route::get('/admin/users/{user}/orders', [UserManagementController::class, 'viewBuyerOrders'])->name('admin.users.orders');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');