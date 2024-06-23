<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleMapController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\Auth\ChangePassword;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LoginController;
use \App\Http\Controllers\Admin\CategoryController;
use \App\Http\Controllers\Admin\SupplierController;
use \App\Http\Controllers\Admin\ProductController;
use \App\Http\Controllers\Admin\OrderController;
use \App\Http\Controllers\Admin\DiscountController as AdminDiscountController;
use \App\Http\Controllers\Admin\ContactController;
use \App\Http\Controllers\Admin\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/register', [HomeController::class, 'register'])->name('register');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
Route::group(['prefix' => 'change-password'], function () {
    Route::get('', [HomeController::class, 'showFormChangePassword'])
        ->name('show_form');
    Route::post('', [ChangePassword::class, 'store'])
        ->name('change_password');
});

// Frontend
Route::group(['middleware' => 'checkLogin'], function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/cancel-order/{id}', [ProfileController::class, 'cancel'])->name('order.cancel');
});

Route::get('bill', [HomeController::class, 'bill'])->name('bill');
Route::post('google-map', [GoogleMapController::class, 'shippingCost'])->name('google_map');
Route::post('open_street_map', [GoogleMapController::class, 'shippingCost'])->name('open_street_map');
Route::get('/search/{search?}', [HomeController::class, 'search'])->name('search');
Route::get('/posts', [HomeController::class, 'posts'])->name('posts');
Route::get('/posts/{slug}', [HomeController::class, 'postDetail'])->name('posts_detail');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about_us');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendTheContact'])->name('send_the_contact');
Route::get('/account-information', [HomeController::class, 'accountInformation'])->name('account_information');
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_cart');
Route::get('/cart-list', [CartController::class, 'cartList'])->name('cart_list');
Route::get('/cart', [CartController::class, 'show'])->name('cart_detail');
Route::post('/change-quantity', [CartController::class, 'update'])->name('change_quantity');
Route::post('/remove-product', [CartController::class, 'remove'])->name('remove_product');
Route::get('/remove-product/{sku?}', [CartController::class, 'removeBookByCart'])->name('remove_product_t');
Route::post('/apply_coupon', [DiscountController::class, 'applyDiscount'])->name('apply_coupon');
Route::post('/remove_coupon', [DiscountController::class, 'destroyDiscount'])->name('remove_coupon');
Route::post('/remove_fee', [GoogleMapController::class, 'destroyFee'])->name('remove_fee');
Route::get('/collections/{category?}', [HomeController::class, 'productsOfList'])->name('product_of_list');
Route::get('/filter', [HomeController::class, 'searchBooksByCategory'])->name('search_books_category');
Route::get('products/{slug}', [HomeController::class, 'productDetails'])->name('product.details');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/details', [HomeController::class, 'details'])->name('details');

Route::group(['prefix' => 'checkout', 'as' => 'checkout.', 'middleware' => 'empty-cart'], function () {
    Route::get('/', [CheckOutController::class, 'index'])->name('index');
    Route::post('/', [CheckOutController::class, 'order'])->name('order');
    Route::get('/vnPayCheck', [CheckOutController::class, 'vnPayCheck']);
    Route::get('/json/provinces', [CheckoutController::class, 'getProvinces'])->name('provinces');
    Route::get('/json/districts/{id}', [CheckoutController::class, 'getDistricts'])->name('districts');
    Route::get('/json/wards/{id}', [CheckoutController::class, 'getWards'])->name('wards');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('show_login_form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::group([
            'middleware' => ['can:read']
        ], function () {
            Route::get('/', [DashboardController::class, 'index'])->name('index');

            Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
                Route::get('/', [BannerController::class, 'index'])->name('index');
                Route::get('/create', [BannerController::class, 'create'])->name('create');
                Route::post('/create', [BannerController::class, 'store'])->name('store');
                Route::get('/show/{id}', [BannerController::class, 'show'])->name('show');
                Route::group(['middleware' => 'role:admin|super-admin'], function () {
                    Route::put('/update/{id}', [BannerController::class, 'update'])->name('update');
                    Route::delete('/delete/{id}', [BannerController::class, 'delete'])->name('delete');
                });
            });

            Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
                Route::get('/', [CategoryController::class, 'index'])->name('index');
                Route::get('/create', [CategoryController::class, 'create'])->name('create');
                Route::post('/create', [CategoryController::class, 'store'])->name('store');
                Route::get('/show/{id}', [CategoryController::class, 'show'])->name('show');
                Route::group(['middleware' => 'role:admin|super-admin'], function () {
                    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
                    Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
                });
            });

            Route::group(['prefix' => 'supplier', 'as' => 'supplier.'], function () {
                Route::get('/', [SupplierController::class, 'index'])->name('index');
                Route::get('/create', [SupplierController::class, 'create'])->name('create');
                Route::post('/create', [SupplierController::class, 'store'])->name('store');
                Route::get('/show/{id}', [SupplierController::class, 'show'])->name('show');
                Route::group(['middleware' => 'role:admin|super-admin'], function () {
                    Route::put('/update/{id}', [SupplierController::class, 'update'])->name('update');
                    Route::delete('/delete/{id}', [SupplierController::class, 'delete'])->name('delete');
                });
            });

            Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
                Route::get('/', [ProductController::class, 'index'])->name('index');
                Route::get('/create', [ProductController::class, 'create'])->name('create');
                Route::post('/create', [ProductController::class, 'store'])->name('store');
                Route::get('/show/{id}', [ProductController::class, 'show'])->name('show');
                Route::group(['middleware' => 'role:admin|super-admin'], function () {
                    Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
                    Route::put('/update-status/{id}',
                        [ProductController::class, 'updateStatus'])->name('update_status');
                    Route::put('/update-quantity/{id}',
                        [ProductController::class, 'updateProductQuantity'])->name('update_quantity');
                    Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
                    Route::get('/recyclebin', [ProductController::class, 'recyclebin'])->name('recyclebin');
                    Route::put('/restore/{id}', [ProductController::class, 'restore'])->name('restore');
                    Route::delete('/forever-delete/{id}',
                        [ProductController::class, 'foreverDelete'])->name('forever_delete');
                    Route::get('/import/{id}', [ProductController::class, 'import'])->name('import');
                });
            });

            Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
                Route::get('/', [CustomerController::class, 'index'])->name('index');
                Route::get('/show/{id}', [CustomerController::class, 'show'])->name('show');
                Route::put('/lock/{id}', [CustomerController::class, 'lock'])->name('lock');
                Route::group(['middleware' => 'role:admin|super-admin'], function () {
                    Route::delete('/delete/{id}', [CustomerController::class, 'delete'])->name('delete');
                    Route::put('/restore/{id}', [CustomerController::class, 'restore'])->name('restore');
                    Route::get('/recyclebin', [CustomerController::class, 'recyclebin'])->name('recyclebin');
                    Route::delete('/forever-delete/{id}',
                        [CustomerController::class, 'foreverDelete'])->name('forever_delete');
                    Route::get('/export', [CustomerController::class, 'export'])->name('export');
                });
            });

            Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
                Route::get('/', [OrderController::class, 'index'])->name('index');
                Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
                Route::group(['middleware' => 'role:admin|super-admin'], function () {
                    Route::put('/update/{id}', [OrderController::class, 'orderStatusUpdate'])->name('update_status');
                    Route::delete('/delete/{id}', [OrderController::class, 'delete'])->name('delete');
                    Route::get('/recyclebin', [OrderController::class, 'recyclebin'])->name('recyclebin');
                    Route::get('/display/{id}', [OrderController::class, 'display'])->name('display');
                    Route::put('/restore/{id}', [OrderController::class, 'restore'])->name('restore');
                    Route::delete('/forever-delete/{id}',
                        [OrderController::class, 'foreverDelete'])->name('forever_delete');
                });
            });

            Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
                Route::get('/', [ContactController::class, 'index'])->name('index');
                Route::get('/show/{id}', [ContactController::class, 'show'])->name('show');
                Route::group(['middleware' => 'role:admin|super-admin'], function () {
                    Route::delete('/delete/{id}', [ContactController::class, 'delete'])->name('delete');
                    Route::put('/restore/{id}', [ContactController::class, 'restore'])->name('restore');
                });
            });

            Route::group(['prefix' => 'discount', 'as' => 'discount.'], function () {
                Route::get('/', [AdminDiscountController::class, 'index'])->name('index');
                Route::get('/create', [AdminDiscountController::class, 'create'])->name('create');
                Route::group(['middleware' => 'role:admin|super-admin'], function () {
                    Route::post('/store', [AdminDiscountController::class, 'store'])->name('store');
                    Route::get('/show/{id}', [AdminDiscountController::class, 'show'])->name('show');
                    Route::put('/update/{id}', [AdminDiscountController::class, 'update'])->name('update');
                    Route::post('/delete/{id}', [AdminDiscountController::class, 'delete'])->name('delete');
                });
            });

            Route::group(['middleware' => ['role:super-admin,admin']], function () {
                Route::get('/config', [DashboardController::class, 'config'])->name('config.index');
                Route::post('/config', [DashboardController::class, 'store'])->name('config.store');
                Route::get('/test', [DashboardController::class, 'test']);

                Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
                    Route::get('/', [AccountController::class, 'index'])->name('index');
                    Route::get('/create', [AccountController::class, 'create'])->name('create');
                    Route::post('/create', [AccountController::class, 'store'])->name('store');
                    Route::get('/show/{id}', [AccountController::class, 'show'])->name('show');
                    Route::put('/update/{id}', [AccountController::class, 'update'])->name('update');
                    Route::delete('/delete/{id}', [AccountController::class, 'delete'])->name('delete');
                    Route::get('/recyclebin', [AccountController::class, 'recyclebin'])->name('recyclebin');
                    Route::put('/restore/{id}', [AccountController::class, 'restore'])->name('restore');
                    Route::delete('/forever-delete/{id}',
                        [AccountController::class, 'foreverDelete'])->name('forever_delete');
                });
            });

            Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
                Route::get('/', [PostController::class, 'index'])->name('index');
                Route::get('/create', [PostController::class, 'create'])->name('create');
                Route::group(['middleware' => 'role:admin|super-admin'], function () {
                    Route::post('/store', [PostController::class, 'store'])->name('store');
                    Route::get('/{id}', [PostController::class, 'show'])->name('show');
                    Route::put('update/{id}', [PostController::class, 'update'])->name('update');
                    Route::put('update-status/{id}',
                        [PostController::class, 'updateStatus'])->name('update_status');
                    Route::delete('delete/{id}', [PostController::class, 'destroy'])->name('delete');
                });
            });
        });
    });
});

Auth::routes();

