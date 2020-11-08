<?php

namespace App\Http\Controllers;

use App\Messages;
use App\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['search']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with([
            'messages'  => Messages::where([
                ['user_id' , Auth::user()->id]
            ])->orderBy('created_at', 'DESC')->get()

        ]);
    }

    public function search(Request $request) {

        $users = User::where([
            ['name', 'like', '%' . $request->search . '%'],
            ['show_account', '=', 'on'],
            ['email_verified_at', '!=', null]
        ])->get();

        $search = $request->search;

        return view('search')->with([
            'users'  => $users,
            'input' => $search
        ]);
    }

}
