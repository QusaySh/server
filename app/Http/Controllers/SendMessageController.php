<?php

namespace App\Http\Controllers;

use App\Messages;
use App\User;
use Illuminate\Http\Request;
use App\Mail\MailtrapExample;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\HelloUser;
use App\Reply;
use GuzzleHttp\Psr7\Message;

class SendMessageController extends Controller
{
    public function index($key){

        $user = User::where('key', $key)->first();

        if ( !isset($_COOKIE[$key]) ) { // من أجل المشاهدة
            setcookie($key, $key, strtotime('+1 day'));
            $user->views += 1;
            $user->save();
        }

        return view('send_message.index')->with([
            'user' => $user,
            'views' => $user->views,
            'message_show' => Messages::where('show_message', 1)->orderBy('id', 'DESC')->simplePaginate(15)
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

    // get reply messgae
    public function get_reply($message_id) {
        $message = Messages::where('id', $message_id)->first();
        return response()->json(array('get_reply' => $message), 200);
    }

    public function reply_message(Request $request) {
        $this->validate($request, [
            'message'   => 'required'
        ], [
            'message.required'  => 'يجب ملئ الحقل',
        ]);

        reply::create([
            'reply' => $request->message,
            'message_id'   => $request->mid
        ]);

        $message = Messages::find($request->mid);
        $message->show_message = 1;
        $message->save();

        return response()->json();
    }

    public function destroy($id) {
        $messages = Messages::find($id);
        $messages->destroy($id);
        $messages->reply()->delete();
        return back()->with('success', 'تم حذف الرسالة بنجاح');
    }

}
