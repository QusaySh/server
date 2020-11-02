<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'name'      => ['required', 'string', 'max:35', 'min:5'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8']
        ],
        [ // Messages
            'name.required'     => 'حقل الإسم مطلوب',
            'name.max'          => 'عدد أحرف الإسم يجب أن لا تتجاوز 35 حرف',
            'name.min'          => 'عدد أحرف الإسم يجب أن لا تقل عن 5 أحرف',

            'email.required'    => 'حقل البريد الإلكتروني مطلوب',
            'email.unique'      => 'البريد الإلكتروني هذا موجود مسبقاً',

            'password.required' => 'حقل كلمة المرور مطلوب',
            'password.min'      => 'عدد أحرف كلمة المرور يجب أن لاتقل عن 8 أحرف']
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'key'   => uniqid() . time(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'show_account'  => isset($data['show_account']) ? $data['show_account'] : 'off'
        ]);
    }
}
