<?php

namespace App\Http\Controllers\admin;

use App\Model\Hotel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index(){
        $hotels = Hotel::where('status','Active')->get();
        return view('admin.roomType.index',compact('hotels'));
    }
    public function ajaxRoomTypes(Request $request){
        dd($request);
    }
}
