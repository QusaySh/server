<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    // Sign In facebook
    public function redirectToFacebook() {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback() {
        try {
            $user = Socialite::driver('facebook')->user();
            if ( $user->email == null ) {
                return redirect()->route('login')->with('error_facebook', 'يجب أن يكون حسابك تم إنشاؤه بواسطة إيميل, قم بإنشاء حساب تقليدي.');
            }
            $finduser = User::where('facebook_id', $user->id)->first();
            if ( User::where('email', $user->email)->first() && !$finduser ) {
                return redirect()->route('login')->with('error_message', 'البريد الإلكتروني التابع لحسابك مسجل لدينا بالطريقة الإعتيادية, قم بتسجيل الدخول');
            } else if ($finduser) {
                Auth::login($finduser);
                return redirect()->route('home');
            } else {
                $newUser = User::create([
                    'key'   => uniqid() . time(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make('aser515411'),
                    'email_verified_at' => date('Y-m-d h:i:s'),
                    'show_account' => 'on',
                    'facebook_id' => $user->id,
                    'avatar' => $user->avatar_original
                ]);
                Auth::login($newUser);
                return redirect()->back();
            }
        }
        catch(Exception $e) {
            return redirect('auth/facebook');
        }
    }


}
