<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountRequest;
use App\Models\Discount;
use App\Repositories\Discount\DiscountRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DiscountController extends Controller
{
    protected $discountRepo;

    public function __construct(DiscountRepositoryInterface $discountRepo)
    {
        $this->discountRepo = $discountRepo;
    }

    public function index()
    {
        $discounts = $this->discountRepo->getAllDiscount();
        return view('admin.discount.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discount.create_update');
    }

    public function store(DiscountRequest $request)
    {
        try {
            $discount = $request->validated();
            $discount['created_by'] = Auth::guard('admin')->user()->id;
            $this->discountRepo->createDiscount($discount);
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Xảy ra lỗi'), 'Thông báo');
            return back();
        }
        toastr()->success(__('Thêm mới thành công'), 'Thông báo');
        return redirect()->route('admin.discount.index');
    }

    public function show($id) {
        $discount = $this->discountRepo->getDiscountById($id);
        return view('admin.discount.create_update', compact('id', 'discount'));
    }

    public function update(DiscountRequest $request, $id)
    {
        try {
            $discount = $request->validated();
            $this->discountRepo->updateDiscount($id, $discount);
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Xảy ra lỗi'), 'Thông báo');
            return back();
        }

        toastr()->success(__('Cập nhật thành công'), 'Thông báo');
        return redirect()->route('admin.discount.index');

    }

    public function delete($id)
    {
        try {
            $this->discountRepo->deleteDiscount($id);
        }catch (\Exception $e){
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }

        toastr()->success(__('Xóa thành công'), 'Thông báo');
        return back();
    }
}
