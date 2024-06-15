<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SupplierStoreRequest;
use App\Http\Requests\Admin\SupplierUpdateRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class SupplierController extends Controller
{
    protected $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $listSupplier = $this->supplierRepository->getAllSupplier();
        return view('admin.suppliers.index', compact('listSupplier'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.suppliers.create_update');
    }

    /**
     * @param  SupplierStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(SupplierStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['created_by'] = Auth::guard('admin')->user()->id;
            $this->supplierRepository->createsupplier($data);
            DB::commit();

            toastr()->success(__('Thêm mới thành công'), 'Thông báo');
            return redirect()->route('admin.supplier.index');
        } catch (\Exception $e) {
            DB::rollBack();
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $data = $this->supplierRepository->getsupplierById($id);
        return view('admin.suppliers.create_update', compact('id', 'data'));
    }

    /**
     * @param  SupplierUpdateRequest  $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(SupplierUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $updatesupplier = $this->supplierRepository->getsupplierById($id);
            $updatesupplier->update($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('Cập nhật không thành công'), 'Thông báo');
            return back();
        }
        toastr()->success(__('Cập nhật thành công'), 'Thông báo');
        return redirect()->route('admin.supplier.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->supplierRepository->deletesupplier($id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            record_error_log($e);
            toastr()->error(__('Lỗi xóa sản phẩm'), 'Thông báo');
            return back();
        }
        toastr()->success(__('Xóa thành công'), 'Thông báo');
        return back();
    }

}
