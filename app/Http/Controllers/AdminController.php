<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin');
    }

    public function room()
    {
        return view('addRoom');
    }

    public function room_page(Request $request)
    {
        $room = new Room();
        $room->name = $request->name;
        $room->save();
        return response()->json();
    }

    public function fetchRoom()
    {
        return Room::all();
    }
}
