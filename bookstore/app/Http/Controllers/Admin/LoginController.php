<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(AdminLogin $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            Auth::guard('admin')->login($user);
            return redirect()->route('admin.index');
        }
        toastr()->warning(__('Thông tin đăng nhập không chính xác'), 'Thông báo');
        return back();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.show_login_form');
    }
}
