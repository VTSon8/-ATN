<?php

namespace App\Http\Middleware;

use App\Models\Account;
use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $customer = Customer::where('email', $user->email)->first();

            if ($customer && $customer->status == 0) {
                toastr()->warning('Tài khoản của bạn đã bị khóa vui lòng liên hệ với cửa hàng', 'Thông báo');
                Auth::logout();
                return redirect()->route('login');
            }
        }

        if (Auth::guard('admin')->check()) {
            $accountLogin = Auth::guard('admin')->user();
            $account = Account::where('email', $accountLogin->email)->first();

            if ($account && $account->status == 0) {
                toastr()->warning('Tài khoản của bạn đã bị khóa vui lòng liên hệ với quản trị viên', 'Thông báo');
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login');
            }
        }

        return $next($request);
    }
}
