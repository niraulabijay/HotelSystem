<?php

namespace App\Http\Controllers\admin;

use App\Model\Hotel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class RoomTypeController extends Controller
{
    public function index(){
        $hotels = Hotel::where('status','Active')->get();
        return view('admin.roomType.index',compact('hotels'));
    }
    public function add($hotelSlug){
        try{
            $hotel = Hotel::where('slug',$hotelSlug)->first();
            return view('admin.roomType.add',compact('hotel'));
        }catch(\Exception $e){
            return redirect()->back();
        }
    }

    public function store(Request $request){
        dd($request);
    }
}
