<?php

namespace App\Http\Controllers\admin;

use App\Model\Brand;
use App\Model\Hotel;
use App\Http\Controllers\Controller;
use App\tableList;
use Illuminate\Http\Request;

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
            'title' => 'required|unique:hotels,title,NULL,id,deleted_at,NULL',
            'brand' => 'required',
            'feature' => 'required|mimes:jpeg,bmp,png',
        ]);
        $hotel = new Hotel();
        $hotel->title = $request->title;
        $hotel->brand_id = $request->brand;
        $hotel->description = $request->description;
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
        return redirect()->back()->with('sweetAlert-success','New Hotel Added Successfully');
    }

    public function edit($id){
        $hotels = Hotel::all();
        $brands = Brand::all();
        $editHotel = Hotel::findOrFail($id);
        return view('admin.hotel.index',compact('hotels','editHotel','brands'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required|unique:hotels,title,'.$request->id.',id,deleted_at,NULL',
            'brand' => 'required',
            'feature' => 'mimes:jpeg,bmp,png',
        ]);
        try{
            $hotel = Hotel::find($request->id);
            $hotel->title = $request->title;
            $hotel->brand_id = $request->brand;
            $hotel->description = $request->description;
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
            return redirect()->back()->with('sweetAlert-error',$e->getMessage());
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
                return redirect()->back()->with('sweetAlert-success', 'Hotel has been deleted successfully');
            } else {
                return redirect()->back()->with('sweetAlert-error', 'Something went wrong, please try again');
            }

        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->getMessage());
            $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
            return redirect()->back()->with('sweetAlert-error', $msg);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('sweetAlert-error', 'Something went wrong, please try again');
        }

    }
}
