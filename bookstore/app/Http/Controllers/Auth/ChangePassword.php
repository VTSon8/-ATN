<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Controller
{
    public function store(ChangePasswordRequest $request)
    {
        DB::beginTransaction();
        try {
            $infoCustomer = $request->validated();
            $credentials = [
                'email' => $request->user()->email,
                'password' => $infoCustomer['password_old'],
            ];

            if (!Auth::attempt($credentials)) {
                toastr()->addNotification('error', 'Mật khẩu hiện tại không chính xác ?', 'Thông báo');
                return back();
            }

            $newPassword = ['password' => Hash::make($infoCustomer['password'])];
            $customer = Customer::where('email', $credentials['email'])->first();
            $customer->update($newPassword);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            record_error_log($e);
            return abort(503);
        }
        toastr()->info(__('Đổi mật khẩu thành công'), 'Thông báo');
        return back();
    }
}
