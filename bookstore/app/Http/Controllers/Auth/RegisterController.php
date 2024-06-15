<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Discount;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'password' => ['required', 'min:8', 'max:20', 'confirmed'],
            'password_confirmation' => ['required', 'min:6', 'max:20'],
        ], [
            'name.required' => __('Tên đăng nhập không được để trống!'),
            'email.required' => __('Email không được để trống!'),
            'email.unique' => __('Địa chỉ email đã được đăng ký mời bạn đăng nhập!'),
            'password.required' => __('Mật khẩu không được để trống!'),
        ], [
            'name' => 'Tên đăng nhập',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'password_confirmation' => 'Xác nhận mật khẩu'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try {
            $customer = Customer::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $coupon = Discount::create([
                'code' => Str::upper(Str::random(6)),
                'discount' => 100000,
                'limit_number' => 1,
                'payment_limit' => 200000,
                'expiration_date' => Carbon::now()->clone()->addMonth(),
                'description' => 'Mã giảm giá 100.000 đ tự động khi đăng ký thành công',
                'created_by' => 1,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            record_error_log($e);
            abort(503);
        }
dd('thanh');
//        $this->dispatch(new SendWelcomeEmail($customer, $coupon));
//        Mail::to($data['email'])->send(new SendAccountInformation($customer, $coupon));
        toastr()->info(__('Đăng ký thành công! Bạn đã nhận được 1 mã giảm giá cho thành viên mới, vui lòng kiểm tra email !!'),
            'Thông báo');
        return $customer;
    }
}
