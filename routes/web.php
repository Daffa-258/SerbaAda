<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Halaman home tidak perlu login


// Routes untuk proses login dan logout
Route::get('/', function () {
    return view('login', [
        'title' => 'login',
    ]);
})->name('login');
Route::resource('/admin/users', UserController::class);

Route::post('/login', [AuthController::class, 'login']);


// Bungkus rute-rute ini dengan middleware auth
Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return view('index', [
            'title' => 'home',
            'categories' => Category::take(3)->get(),
            'products' => Product::take(3)->get(),
            'userId' => auth()->check() ? auth()->user()->id : null
        ]);
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin routes
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/products', ProductController::class);
    Route::resource('/admin/sales', SaleController::class);

    // Routes untuk melihat semua kategori dan produk
    Route::get('/all-categories', function (Request $request) {
        $search = $request->input('search');
        $query = Category::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $categories = $query->get();

        return view('all-categories', [
            'title' => 'categories',
            'categories' => $categories,
            'userId' => auth()->user()->id,
        ]);
    });

    Route::get('/all-products', function (Request $request) {
        $search = $request->input('search');
        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $products = $query->get();

        return view('all-products', [
            'title' => 'products',
            'products' => $products,
            'userId' => auth()->user()->id,
        ]);
    });

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

    // Sales routes
    Route::post('/cart/buy', [SaleController::class, 'buy'])->name('cart.buy');
    Route::get('/history', [SaleController::class, 'history'])->name('history');
});
