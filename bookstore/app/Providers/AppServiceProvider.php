<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    const DEFAULT_SELLING = 5;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('admin.common.pagination');

        \view()->composer('*', function ($view) {
            $viewName = $view->getName();
            if (in_array($viewName, ['layouts.index', 'components.category', 'layouts.sidebar']) && !str_starts_with($viewName, 'admin.')) {
                $seconds = 600 * 10;
                $key_category = 'categories';
                $key_selling = 'sellingBooks';

                $categories = Cache::remember($key_category, $seconds, function () {
                    return  Category::whereNull('parent_id')->with('children')->get();
                });

                $sellingBooks = Cache::remember($key_selling, $seconds, function () {
                    return  Product::orderBy('number_buy', 'desc')->limit(self::DEFAULT_SELLING)->get();
                });

                $view->with([
                    'categories' => $categories,
                    'sellingBooks' => $sellingBooks,
                ]);
            }

            if (in_array($viewName, ['book_by_category'])) {
                $authors = Product::distinct()->pluck('author');
                $suppliers = Supplier::all();

                $view->with([
                    'authors' => $authors,
                    'suppliers' => $suppliers,
                ]);
            }

            if (in_array($viewName, ['details', 'book_by_category'])) {
                $seconds = 600 * 10;
                $key = 'promotional_books';
                $promotionalProducts = Cache::remember($key, $seconds, function () {
                    return Product::whereNotNull('sale')
                        ->latest('sale')
                        ->limit(config('common.promotional_limit'))->get();
                });

                $view->with([
                    'promotionalProducts' => $promotionalProducts,
                ]);
            }

            if (in_array($viewName, ['admin.common.header'])) {
                $noti = DB::table('orders')
                    ->select(
                        DB::raw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as total_pending'),
                        DB::raw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as total_delivering')
                    )
                    ->whereIn('status', [0, 1])
                    ->first();
                $view->with([
                    'noti' => $noti,
                ]);
            }
        });
    }
}
