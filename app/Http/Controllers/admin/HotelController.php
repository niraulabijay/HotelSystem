<?php

namespace App\Http\Controllers\admin;

use App\Model\Brand;
use App\Model\Hotel;
use App\Http\Controllers\Controller;
use App\tableList;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class HotelController extends Controller
{
    public function index(){
        $hotels = Hotel::all();
        $brands = Brand::all();
        return view('admin.hotel.index',compact('hotels','brands'));
    }

    public function add(Request $request){
        // dd($request);
        $request->validate([
            'title' => 'required|unique:hotels,title',
            'brand' => 'required',
            'feature' => 'required|mimes:jpeg,bmp,png',
            'location' => 'required',
        ]);
        try{
            $hotel = new Hotel();
            $hotel->title = $request->title;
            $hotel->brand_id = $request->brand;
            $hotel->location = $request->location;
            if($request->status){
                $hotel->status = "Active";
            }else{
                $hotel->status = "Inactive";
            }
            $hotel->save();
            if($request->hasFile('feature')){
                $hotel->addMediaFromRequest('feature')
                    ->toMediaCollection('hotel_feature');
            }
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Server Error');
            return redirect()->back();
        }
        Toastr::success('New Hotel Added Successfully','Operation Success');
        return redirect()->back();
    }

    public function edit($id){
        $hotels = Hotel::all();
        $brands = Brand::all();
        $editHotel = Hotel::findOrFail($id);
        return view('admin.hotel.index',compact('hotels','editHotel','brands'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required|unique:hotels,title,'.$request->id.',id',
            'brand' => 'required',
            'feature' => 'mimes:jpeg,bmp,png',
            'location' => 'required'
        ]);
        try{
            $hotel = Hotel::find($request->id);
            $hotel->title = $request->title;
            $hotel->brand_id = $request->brand;
            $hotel->location = $request->location;
            if($request->status){
                $hotel->status = "Active";
            }else{
                $hotel->status = "Inactive";
            }
            $hotel->save();
            if($request->hasFile('feature')){
                $hotel->addMediaFromRequest('feature')
                    ->toMediaCollection('hotel_feature');
            }
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Server Error');
            return redirect()->back();
        }
        return redirect()->route('admin.hotels')->with('sweetAlert-success','Hotel Updated Successfully');
    }

    public function delete(Request $request){
        $id_key = 'hotel_id';

        $tables = tableList::getTableList($id_key);
        $hotel = Hotel::find($request->hotel_id);
        try {
            if($hotel->hasMedia('hotel_feature')){
                foreach($hotel->getMedia('hotel_feature') as $media){
                    $delete = $hotel->deleteMedia($media);
                }
            }
            $delete_query = $hotel->delete();
            if ($delete_query) {
                Toastr::success('Hotel has been deleted successfully', 'Operation Success');
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
