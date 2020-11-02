<?php

namespace App\Http\Controllers;

use App\Messages;
use App\SendMessage;
use App\User;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Message;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index')->with([
            'count_user'            => User::where('admin', 0)->count(),
            'count_admin'           => User::where('admin', 1)->count(),
            'count_user_facebook'   => User::where('facebook_id', '!=' , null)->count(),
            'count_user_gmail'      => User::where('facebook_id', '=' , null)->count(),

            'count_message'         => Messages::all()->count()
        ]);
    }

    public function users(){
        return view('admin.users')->with([
            'users' => User::simplePaginate(15)
        ]);
    }
    public function deleteUser($id){
        $user = User::find($id);

        if ( $user->avatar != 'avatar.png' ) {
            @unlink("avatar/" . $user->avatar);
        }
        $user->delete($user->id);
        $user->messages()->delete();
        return back();
    }
    public function rulesUser($id){
        $user = User::find($id);
        if ( $user->admin ) {
            $user->admin = false;
        } else {
            $user->admin = true;
        }
        $user->save();
        return back()->with('success_message', 'تم تعديل صلاحية المستخدم');
    }

    public function deleteMessage($id){
        $message = Messages::find($id);
        $message->delete($message->id);
        return back();
    }

    public function messages(){
        return view('admin.messages')->with([
            'messages' => Messages::simplePaginate(15)
        ]);
    }
}
