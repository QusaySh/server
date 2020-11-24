<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Messages;
use App\User;
use Illuminate\Http\Request;
use App\Mail\MailtrapExample;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\HelloUser;
use App\Reply;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Auth;

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
            'message_show' => Messages::where([
                ['show_message', 1],
                ['user_id', $user->id]
            ])->orderBy('id', 'DESC')->simplePaginate(15)
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

        if ( $user->send_email && $user->email != null ) {
            Notification::route('mail', $user->email)->notify(new HelloUser($user));
        }

        return back()->with('success_message', 'تم إرسال الرسالة بنجاح');

    }

    // get reply messgae
    // عند الضغط على رد
    public function get_reply($message_id) {
        $message = Messages::where('id', $message_id)->first();
        return response()->json(array('get_reply' => $message), 200);
    }

    // عند الضغط على ارسال الرد
    public function reply_message(Request $request) {
        $this->validate($request, [
            'message'   => 'required'
        ], [
            'message.required'  => 'يجب ملئ الحقل',
        ]);

        reply::create([
            'reply' => $request->message,
            'message_id'   => strip_tags($request->mid)
        ]);

        $message = Messages::find($request->mid);
        $message->show_message = 1;
        $message->save();

        $count_reply = Reply::where('message_id', $request->mid)->count();

        return response()->json(['count_reply' => $count_reply]);
    }

    // show reply messgae
    public function show_reply($message_id) {
        $messages = Reply::where('message_id', $message_id)->get();
        $show_reply = "";
        if ( $messages->count() > 0 ) {
            foreach ( $messages as $message ) {
                $show_reply .= 
                '<ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ' . $message->reply . '
                        <span class="text-danger pointer delete-reply" data-rid="' . $message->id . '" data-mid="' . $message->message_id . '"><i class="fa fa-fw fa-close"></i></span>
                    </li>
              </ul>';
            }
        } else {
            $show_reply .= 
            '<div class="alert alert-primary" role="alert">
                لايوجد ردود لهذه الرسالة
            </div>';
        }
        return response()->json(array('show_reply' => $show_reply), 200);
    }
    // delete a reply
    public function delete_reply($reply_id, $message_id) {
        $count_reply_for_message = Reply::where('message_id', $message_id)->count();

        if ( $count_reply_for_message == 1 ) {
            $message = Messages::where('id', $message_id)->first();
            $message->show_message = 0;
            $message->save();
        }
        $reply = Reply::find($reply_id);
        $reply->delete($reply_id);

        $count_reply = Reply::where('message_id', $message_id)->count();

        return response()->json(['count_reply' => $count_reply]);
    }

    // add a message to fav
    public function add_favorite(Request $request){
        $get_message = Messages::find($request->id);
        // في حال تم حفظها
        $fav = Favorite::where('message_id', $request->id)->get();
        if ( $fav->isNotEmpty() ) {
            $fav[0]->destroy($fav[0]->id);
            return back()->with('success', 'تم إزالة الرسالة من المفضلة');
        } else { // في حال اضافتها
            $fav = $get_message->favorite()->create([
                'user_id'       => Auth::user()->id,
                'message_id'    => $request->id
            ]);
            return back()->with('success', 'تم إضافة الرسالة إلى المفضلة');
        }
    }
    // show a favorite message
    public function show_favorite(Request $request){
        $favorites = Favorite::where('user_id', Auth::user()->id)->get();
        $layout_fav = "";
        if ( $favorites->isNotEmpty() ) {
            foreach ( $favorites as $fav ) {
                $layout_fav .= '<div class="row spinner justify-content-center">
                <div class="spinner-border text-info" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
              <div class="message mb-3 border rounded-lg wow bounceIn" data-wow-offset="30">
                <div class="text-left mt-0">
                  <a class="add-fav" href="' . route("send_message.add_favorite", ["id" => $fav->message->id]) . '" data-toggle="tooltip" data-placement="top" title="حذف من المفضلة"><i class="fa fa-save text-success fa-fw"></i></a>
                  <a class="delete-message" href="'. route("send_message.delete", ["id" => $fav->message->id]) .'" data-toggle="tooltip" data-placement="top" title="حذف الرسالة"><i class="fa fa-close text-danger fa-fw"></i></a>
                </div>
                <p class="mb-0 mt-3">' . $fav->message->message . '</p>
                <hr class="mb-2" />
                <div class="date row justify-content-between">
                    <span class="pointer text-info get-reply" data-mid="' . $fav->message->id . '" data-toggle="modal" data-target="#reply_model"><i class="fa fa-reply fa-fw"></i> رد</span>
                    <span class="pointer text-success show-reply" data-mid="' . $fav->message->id . '" data-toggle="modal" data-target="#show_reply_model"><i class="fa fa-eye fa-fw"></i> عرض الردود (<span class="count-reply">' . $fav->message->reply->count() . '</span>)</span>
                    <span class=""><i class="fa fa-clock-o fa-fw"></i> ' . $fav->message->created_at->diffForHumans() . '</span>
                </div>
                <div class="clearfix"></div>
            </div>';
            }
        } else {
            $layout_fav .= '<div class="alert alert-primary" role="alert">
                لم تقم بإضافة رسائل إلى المفضلة.
            </div>';
        }
        return response()->json(['favorite' => $layout_fav]);
    }
    // delete a message and reply
    public function destroy($id) {
        $messages = Messages::find($id);
        $messages->destroy($id);
        $messages->reply()->delete();
        $messages->favorite()->delete();
        return back()->with('success', 'تم حذف الرسالة بنجاح');
    }

}
