<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AccountRequest;
use App\Repositories\Account\AccountRepositoryInterface;
use App\Services\UploadImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\SkuObservable;

class AccountController extends Controller
{

    private $accountRepository;
    private $uploadImage;

    public function __construct(AccountRepositoryInterface $accountRepository, UploadImage $uploadImage)
    {
        $this->accountRepository = $accountRepository;
        $this->uploadImage = $uploadImage;
    }

    public function index()
    {
        $total_trash = $this->accountRepository->totalTrash();
        $accounts = $this->accountRepository->getAllAccount();

        return view('admin.accounts.index', compact('total_trash', 'accounts'));
    }

    public function create()
    {
        return view('admin.accounts.create_update');
    }


    public function store(AccountRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            if (isset($data['avatar'])) {
                $data['avatar'] = $this->uploadImage->handleUploadedImage($data['avatar']);
            }
            $data['created_by'] = Auth::guard('admin')->user()->id;
            $account = $this->accountRepository->createAccount($data);
            $account->assignRole(config('constants.roles')[$account->role_id]);

            toastr()->success(__('Thêm mới thành công'), 'Thông báo');
            return redirect()->route('admin.accounts.index');
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Xảy ra lỗi'), 'Thông báo');
            return back();
        }


    }


    public function show($id)
    {
        $account = $this->accountRepository->getAccountById($id);
        return view('admin.accounts.create_update', compact('id', 'account'));
    }

    public function update(AccountRequest $request, $id): RedirectResponse
    {
        try {
            $updateAccount = $request->validated();
            $account = $this->accountRepository->getAccountById($id);
            $avatar = $updateAccount['avatar'] ?? null;
            $fileName = $this->uploadImage->handleUploadedImage($avatar);
            if (!empty($fileName)) {
                $this->uploadImage->handleUnlinkImage($account->avatar);
                $updateAccount['avatar'] = $fileName;
            }
            $account->update($updateAccount);

            toastr()->success(__('Cập nhật thành công'), 'Thông báo');
            return redirect()->route('admin.accounts.index');
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Xảy ra lỗi'), 'Thông báo');
            return back();
        }

    }


    public function delete($id): RedirectResponse
    {
        try {
            $this->accountRepository->delete($id);

            toastr()->success(__('Xóa thành công'), 'Thông báo');
            return back();
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }
    }

    public function recyclebin()
    {
        $accounts = $this->accountRepository->getOnlyTrashed();
        return view('admin.accounts.recyclebin', compact('accounts'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
        try {
            $this->accountRepository->restoreAccountById($id);
            toastr()->success(__('Khôi phục thành công'), 'Thông báo');
        } catch (\Exception $e) {
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
        }

        return back();
    }


    public function foreverDelete($id): RedirectResponse
    {
        try {
            $account = $this->accountRepository->getAccountById($id);
            $this->uploadImage->handleUnlinkImage($account->avatar);
            $this->accountRepository->foreverDeleteAccountById($id);
            toastr()->success(__('Xóa thành công'), 'Thông báo');
            return back();
        } catch (\Exception $e) {
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }
    }
}
