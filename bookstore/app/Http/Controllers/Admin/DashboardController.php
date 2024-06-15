<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ConfigRequest;
use App\Models\Config;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $total = [
            'products' => Product::query()->count(),
            'posts' => Post::query()->count(),
            'contacts' => Contact::query()->count(),
            'orders' => Order::query()->count(),
        ];


        $year = Carbon::now()->year;
        $data[] = ['Month', 'Bán ra', 'Đơn hàng'];
        $total_revenue = 0;
        for ($i = 1; $i <= 12; $i++) {
            $orderFollowMonth = Order::query()
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $i)
                ->where('status', Order::DELIVERED)
                ->withSum('order_product', 'quantity')
                ->get();

            $revenueMonth[] = $orderFollowMonth->sum('price');
            $total_orders = $orderFollowMonth->count();
            $total_revenue += $orderFollowMonth->sum('price');
            $total_products = $orderFollowMonth->sum('order_product_sum_quantity');
            $monthOfYear = $year.'/'.($i <= 9 ? "0$i" : $i);
            $data[$i] = [$monthOfYear, $total_products, $total_orders];
        }

        return view('admin.dashboard.index', compact('total', 'data', 'total_revenue', 'revenueMonth'));
    }

    public function config()
    {
        $config = Config::first();
        return view('admin.config', compact('config'));
    }

    public function store(ConfigRequest $request) {
        DB::beginTransaction();
        try {
            $config = $request->validated();
            Config::updateOrCreate(['id' => 1], $config);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            record_error_log($e);
            abort(503);
        }

        toastr()->success(__('Cài đặt thành công'), 'Thông báo');
        return back();
    }
}
