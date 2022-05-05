<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomUser;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }
    public function  delete_room(){
    $del_room = RoomUser::where('user_id',auth()->user()->id)->first();

        if($del_room != null){
            $del_room->delete();
        }
        return ['status'=>'succsess'];
    }

    public function home_fetchRoom()
    {
        return Room::all();
    }
}
