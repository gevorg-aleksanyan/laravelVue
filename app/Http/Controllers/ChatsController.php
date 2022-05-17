<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
//
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function index(){

        return view('chats');
    }

    public function chatPage(){
        return ['satatus'=>'succsess'];
    }



    public function messagesPage($id){
        $del_room = RoomUser::where('user_id',auth()->id())->where('room_id',$id)->first();
       if($del_room != null){
           $del_room->delete();
       }

        $room_user=new RoomUser();
        $room_user->room_id=$id;
        $room_user->user_id=Auth()->id();
        $room_user->save();
        return Message::where('room_id',$id)->with('user')->get();
    }


    public function sendMessages(Request $request,$id){
        $messages = auth()->user()->messages()->create([
            'message'=>$request->message,
            'room_id'=>$id,
        ]);

        broadcast(new MessageSent($messages->load('user')))->toOthers();
        return ['status'=>'succsess', 'user'=>auth()->user()];
    }
}
