<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Vendor\PaketController as VendorPaketController;
use App\Http\Controllers\Vendor\OrderController as VendorOrderController;
use App\Http\Controllers\Kurir\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - Qatring Catering
|--------------------------------------------------------------------------
| Struktur: Guest → Auth → Customer → Vendor
| Semua route terorganisir dan bebas conflict!
*/

// ============================================================================
// 🚪 GUEST ROUTES (Belum Login)
// ============================================================================

// Health check route - HARUS PALING ATAS
Route::get('/health', function () {
    return 'OK';
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register'])->name('register.post');
});

// ============================================================================
// 🔐 AUTHENTICATED ROUTES (Sudah Login)
// ============================================================================
Route::middleware('auth')->group(function () {

    // --- Logout (Semua User) ---
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // --- Public Pages (Semua User Bisa Akses) ---
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/paket/{id}', [PaketController::class, 'show'])->name('paket.detail');

    // --- Dashboard Redirect (Berdasarkan Role) ---
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard.redirect');

    // ========================================================================
    // 🛒 CUSTOMER ONLY ROUTES
    // ========================================================================

    // Customer Dashboard (Route Name: customer.dashboard)
    Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

    // Cart Management (Route Name: customer.cart, customer.cart.add, dll)
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

        // Checkout & Order
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/order', [CustomerOrderController::class, 'store'])->name('order.store');

        // Order History
        Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{id}', [CustomerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}/cancel', [CustomerOrderController::class, 'cancel'])->name('orders.cancel');
        Route::post('/orders/{id}/confirm-received', [CustomerOrderController::class, 'confirmReceived'])->name('orders.confirm');
    });

    // ========================================================================
    // 🏪 VENDOR ONLY ROUTES (Middleware: vendor)
    // ========================================================================
    Route::middleware('vendor')->prefix('vendor')->name('vendor.')->group(function () {

        // Vendor Dashboard (Route Name: vendor.dashboard)
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

        // --- Paket Management (CRUD) ---
        Route::prefix('paket')->name('paket.')->group(function () {
            Route::get('/', [VendorPaketController::class, 'index'])->name('index');
            Route::get('/create', [VendorPaketController::class, 'create'])->name('create');
            Route::post('/', [VendorPaketController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [VendorPaketController::class, 'edit'])->name('edit');
            Route::put('/{id}', [VendorPaketController::class, 'update'])->name('update');
            Route::delete('/{id}', [VendorPaketController::class, 'destroy'])->name('destroy');
        });

        // --- Order Management (Vendor) ---
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [VendorOrderController::class, 'index'])->name('index');
            Route::get('/{id}', [VendorOrderController::class, 'show'])->name('show');
            Route::post('/{id}/accept', [VendorOrderController::class, 'accept'])->name('accept');
            Route::post('/{id}/reject', [VendorOrderController::class, 'reject'])->name('reject');
            Route::post('/{id}/start-processing', [VendorOrderController::class, 'startProcessing'])->name('process');
            Route::post('/{id}/send', [VendorOrderController::class, 'send'])->name('send');
            Route::post('/{id}/mark-paid', [VendorOrderController::class, 'markAsPaid'])->name('mark-paid');
        });

Route::middleware(['auth', 'kurir'])->prefix('kurir')->name('kurir.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/orders/{id}/accept', [DashboardController::class, 'accept'])->name('orders.accept');
    Route::post('/orders/{id}/deliver', [DashboardController::class, 'deliver'])->name('orders.deliver');
});


    }); // End Vendor Group

}); // End Auth Group

// ============================================================================
// 🌐 PUBLIC ROUTES (Tanpa Auth - Untuk Halaman Info)
// ============================================================================
Route::get('/tentang', function () {
    return view('pages.tentang');
})->name('tentang');

Route::get('/kontak', function () {
    return view('pages.kontak');
})->name('kontak');
