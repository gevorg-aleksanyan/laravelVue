<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('chats');
    }

    public function messages_page(){

        return Message::with('user')->get();
    }

    public function send_messages(Request $request){

        $messages = auth()->user()->messages()->create([
            'message'=>$request->message,
        ]);

        broadcast(new MessageSent($messages->load('user')))->toOthers();

        return ['status'=>'succsess'];
    }
}
