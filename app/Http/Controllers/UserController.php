<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{

    public function edit()
    {
        return view('profile.edit');
    }

    public function compress($tmp_name, $name, $c) {
        $info = getimagesize($tmp_name);

        if ($info["mime"] == "image/jpeg") {
            $img = imagecreatefromjpeg($tmp_name);
        } else if ($info["mime"] == "image/png") {
            $img = imagecreatefrompng($tmp_name);
        } else if ($info["mime"] == "image/jpg") {
            $img = imagecreatefromjpg($tmp_name);
        }

        imagejpeg($img, $name, $c);

        return $name;
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        
        // rules
        $rules = [
            'name'      => 'required|string|max:35|min:5',
        ];

        if ( !empty($request->password) ) {
            $rules['password'] = 'string|min:8';
        }

        // add rules email
        if ( Auth::user()->facebook_id == null ) {
            $rules['email'] = 'required|string|email|max:255|unique:users,email,'. Auth::user()->id;
        }
        // add rules avatar
        if ( $request->hasFile('avatar_input') ) {
            $rules['avatar_input'] = 'image|mimes:png,jpg,jpeg|max:10000';
        }
        // add rules url facebook
        if ( !empty($request->facebook) ) {
            $rules['facebook'] = 'url';
        }
        // add rules url instagram
        if ( !empty($request->instagram) ) {
            $rules['instagram'] = 'url';
        }

        // check validate
        $this->validate($request, $rules,
        [
            'name.required'     => 'حقل الإسم مطلوب',
            'name.max'          => 'عدد أحرف الإسم يجب أن لا تتجاوز 35 حرف',
            'name.min'          => 'عدد أحرف الإسم يجب أن لا تقل عن 5 أحرف',

            'email.required'    => 'حقل البريد الإلكتروني مطلوب',
            'email.unique'      => 'البريد الإلكتروني هذا موجود مسبقاً',

            'password.min'      => 'عدد أحرف كلمة المرور يجب أن لاتقل عن 8 أحرف',

            'avatar_input.image'      => 'يجب إختيار الصور فقط',
            'avatar_input.mimes'      => 'يجب إختيار الأنواع التالية: png - jpg - jpeg',
            'avatar_input.max'        => 'حجم الصورة يجب أن لاتتعدى 10 ميغا',

            'facebook.url'            => 'يجب إدخال رابط حسابك الفيسبوك',
            'instagram.url'           => 'يجب إدخال رابط حسابك الانستغرام'
            
        ]);

        // set name
        $user->name = $request->name; // set name
        // set email
        $user->email = Auth::user()->facebook_id == null ? $request->email : Auth::user()->email;

        // delete verifiy
        if ( $request->email != Auth::user()->email ) {
            $user->email_verified_at = null;
        }
        // set password
        $user->password = empty($request->password) ? Auth::user()->password : Hash::make($request->password);

        // set avatar
        if ( $request->hasFile('avatar_input') ) {

            $new_name = date('Y-m-d') . "_" . time() . "." . $request->file('avatar_input')->getClientOriginalExtension();
            $tmp_image = $_FILES['avatar_input']['tmp_name'];
            
            $d = $this->compress($tmp_image, 'avatar/' . $new_name, 25);
            
            $request->file('avatar_input')->store($d);
        
            @unlink('avatar/' . Auth::user()->avatar); // حذف الصورة

            $user->avatar = $new_name;

        } else {
            Auth::user()->avatar;
        }
        
        // set show user
        $user->show_account = $request->show_account != null ? $request->show_account : 'off';
        // Set Send Email
        $user->send_email = $request->send_email != null ? 1 : 0;
        // set url facebook and instagram
        $user->facebook = $request->facebook;
        $user->instagram = $request->instagram;

        $user->save();
        return back()->with('success_message', 'تم حفظ البيانات بنجاح');
    }

    public function destroy()
    {
        $user = User::find(Auth::user()->id);

        if ( $user->avatar != 'avatar.png' ) {
            @unlink("avatar/" . Auth::user()->avatar);
        }
        $user->delete(Auth::user()->id);
        $user->messages()->delete();
        return back();
    }
}
