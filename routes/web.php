<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ContactInquiryController as AdminContactInquiryController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home/welcome page - these serve different purposes as specified by client
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/home', [HomeController::class, 'index'])->name('home.index');

// Dashboard page
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Product & Category Browsing
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Static Pages
Route::get('/promotions', function () {
    return view('promotions');
})->name('promotions');

Route::get('/faqs', function () {
    return view('faqs');
})->name('faqs');

Route::get('/customer-service', [CustomerServiceController::class, 'index'])->name('customer-service.index');
Route::post('/customer-service', [CustomerServiceController::class, 'store'])->name('customer-service.store');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/refund', function () {
    return view('refund');
})->name('refund');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Feedback & Testimonials
Route::get('/testimonials', [FeedbackController::class, 'index'])->name('testimonials');
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// Cart Routes (public but may contain session data)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // User Profile Management
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.edit');
    Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Keeping the existing user-profile route as requested, but now properly grouped
    Route::get('/user-profile', [HomeController::class, 'profile'])->name('user.profile.home');
    Route::post('/profile/address', [HomeController::class, 'storeAddress'])->name('profile.address.store');

    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/{id}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');

    // Checkout & Orders
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function() {
        // Admin Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Admin Resource Management (using consistent naming)
        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('orders', AdminOrderController::class);
        Route::get('contact-inquiries', [AdminContactInquiryController::class, 'index'])->name('contact-inquiries.index');
        Route::get('contact-inquiries/{contactInquiry}', [AdminContactInquiryController::class, 'show'])->name('contact-inquiries.show');
        Route::post('contact-inquiries/{contactInquiry}/reply', [AdminContactInquiryController::class, 'reply'])->name('contact-inquiries.reply');
        
        // Admin Reports
        Route::post('reports/export', [ReportController::class, 'export'])->name('reports.export');

        // Admin Promotions CRUD
        Route::resource('promotions', \App\Http\Controllers\Admin\PromotionController::class)->except(['show']);
    });

// Payment API Callback Routes
Route::post('/api/momo/callback', [CheckoutController::class, 'momoCallback'])->name('momo.callback');

// Authentication Routes (from Laravel's auth.php)
require __DIR__.'/auth.php';