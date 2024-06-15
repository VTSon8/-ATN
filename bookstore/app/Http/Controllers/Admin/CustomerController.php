<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Services\UploadImage;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerRepository;
    private $uploadImage;

    public function __construct(CustomerRepositoryInterface $customerRepository, UploadImage $uploadImage)
    {
        $this->customerRepository = $customerRepository;
        $this->uploadImage = $uploadImage;
    }

    public function index()
    {
        $customers = $this->customerRepository->getAllCustomer();
        $total_trash = $this->customerRepository->totalTrash();
        return view('admin.customer.index', compact('customers', 'total_trash'));
    }

    public function show($id)
    {
        $customer = $this->customerRepository->getCustomerById($id);
        return view('admin.customer.detail', compact('customer'));
    }

    public function lock($id)
    {
        try {
            $customer = Customer::find($id);
            $customer->status = ($customer->status == 1) ? 0 : 1;
            $customer->save();
        }catch (\Exception $e) {
            record_error_log($e);
            toastr()->error('Có lỗi xảy ra', 'Thông báo');
        }
        toastr()->success('Cập nhật trạng thái khoản thành công', 'Thông báo');
        return back();
    }

    public function delete($id)
    {
        try {
            $this->customerRepository->delete($id);
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
        }
        toastr()->success(__('Xóa thành công'), 'Thông báo');
        return back();
    }

    public function recyclebin()
    {
        $customers = $this->customerRepository->getOnlyTrashed();
        return view('admin.customer.recyclebin', compact('customers'));
    }

    public function restore($id)
    {
        try {
            $this->customerRepository->restoreCustomerById($id);
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
        }
        toastr()->success(__('Khôi phục thành công'), 'Thông báo');
        return back();
    }

    public function foreverDelete($id)
    {
        try {
            $customer = $this->customerRepository->getCustomerByIdOnlyTrashed($id);
            if ($customer) {
                $this->uploadImage->handleUnlinkImage($customer->avatar);
                $this->customerRepository->foreverDeleteCustomerById($id);
            }
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }
        toastr()->success(__('Xóa thành công'), 'Thông báo');
        return back();
    }


}
