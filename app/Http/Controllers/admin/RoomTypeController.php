<?php

namespace App\Http\Controllers\admin;

use App\Model\Hotel;
use App\Http\Controllers\Controller;
use App\Model\Room;
use App\Model\RoomType;
use App\tableList;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

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
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
    }

    public function store(Request $request, $hotelSlug){
        // dd($request);
        $request->validate([
            'hotel_id' =>'required',
            'title' => 'required',
            'status' => 'required',
            'feature_image' => 'required|mimes:png,jpg,gif,webp,JPG,jpeg,JPEG,PNG',
            'base_price' => 'required|min:0',
            'no_of_guests' => 'required|min:1',
        ]);
        try{
            $roomType = new RoomType();
            $roomType->title = $request->title;
            $roomType->hotel_id = $request->hotel_id;
            $roomType->description = $request->description;
            $roomType->no_of_adult = $request->no_of_guests;
            $roomType->base_price = $request->base_price*100;
            $roomType->status = $request->status == "on" ? "Active" : "Inactive";
            $roomType->save();

            if($request->hasFile('feature_image')){
                $roomType->addMediaFromRequest('feature_image')
                    ->toMediaCollection('feature_image');
            }

            Toastr::success('Room type created','Operation Success');
            return redirect()->route('admin.roomType');

        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $slug){
        $editRoomType = RoomType::where('slug',$slug)->first();
        $hotel = $editRoomType->hotel;
        if(!$editRoomType){
            Toastr::error('Data not found','Operation Failed');
            return redirect()->route('admin.roomType');
        }
        return view('admin.roomType.add',compact('hotel','editRoomType'));
    }

    public function update(Request $request, $slug){
        $request->validate([
            'room_type' =>'required',
            'title' => 'required',
            'status' => 'required',
            'feature_image' => 'mimes:png,jpg,gif,webp,JPG,jpeg,JPEG,PNG',
            'base_price' => 'required|min:0',
            'no_of_guests' => 'required|min:1',
        ]);
        try{
            $roomType = RoomType::find($request->room_type);
            $roomType->title = $request->title;
            $roomType->description = $request->description;
            $roomType->no_of_adult = $request->no_of_guests;
            $roomType->base_price = $request->base_price*100;
            $roomType->status = $request->status == "on" ? "Active" : "Inactive";
            $roomType->update();

            if($request->hasFile('feature_image')){
                $roomType->addMediaFromRequest('feature_image')
                    ->toMediaCollection('feature_image');
            }

            Toastr::success('Room type updated','Operation Success');
            return redirect()->route('admin.roomType');

        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
    }

    public function delete(Request $request){
        $roomType = RoomType::find($request->room_type_id);
        if(!$roomType){
            Toastr::error('Room Type Not Found','Cannot Delete Room Type');
            return redirect()->back();
        }
        $id_key = 'room_type_id';

        $tables = tableList::getTableList($id_key);
        try {
            $delete_query = $roomType->delete();
            if ($delete_query) {
                Toastr::success('Room Type has been deleted successfully', 'Operation Success');
                return redirect()->back();
            } else {
                Toastr::error('Something went wrong.', 'Failed to Delete');
                return redirect()->back();
            }

        } catch (\Illuminate\Database\QueryException $e) {
            $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
            Toastr::error($msg, 'Operation Failed');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Server Error');
            return redirect()->back();
        }
    }

}
