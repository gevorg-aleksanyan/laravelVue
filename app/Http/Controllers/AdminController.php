<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin');
    }

    public function room()
    {

        return view('add-room');
    }

    public function room_page(Request $request)
    {
        $room = new Room();
        if($request->name){
            $room->name = $request->name;
            $room->save();
            $status = 'Success';
            return response()->json($status);
        }else{
            $status = 'Error';
            return response()->json($status);
        }

    }

    public function fetchRoom()
    {
        return Room::all();
    }
}
