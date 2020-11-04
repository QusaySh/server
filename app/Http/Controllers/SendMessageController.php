<?php

namespace App\Http\Controllers;

use App\Messages;
use App\User;
use Illuminate\Http\Request;
use App\Mail\MailtrapExample;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\HelloUser;
use GuzzleHttp\Psr7\Message;

class SendMessageController extends Controller
{
    public function index($key){

        $user = User::where('key', $key)->first();

        if ( !isset($_COOKIE[$key]) ) {
            setcookie($key, $key, strtotime('+1 day'));
            $user->views += 1;
            $user->save();
        }
        return view('send_message.index')->with([
            'user' => $user,
            'views' => $user->views
        ]);
    }

    public function send(Request $request, $id) {
        $this->validate($request, [
            'message'   => 'required'
        ],
        [
            'message.required'  => 'يجب ملئ حقل الرسالة'
        ]);

        Messages::create([
            'message'   => $request->message,
            'user_id'   => $id
        ]); 

        $user = User::find($id);

        if ( $user->send_email ) {
            Notification::route('mail', $user->email)->notify(new HelloUser($user));
        }

        return back()->with('success_message', 'تم إرسال الرسالة بنجاح');

    }

    public function destroy($id) {
        $messages = Messages::find($id);
        $messages->destroy($id);
        return back()->with('success', 'تم حذف الرسالة بنجاح');
    }

}
