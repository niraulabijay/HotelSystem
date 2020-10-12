<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\Room;
use App\tableList;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function store(Request $request){
        $input = $request->all();
        $validator = Validator::make($input,[
            'room_type_id'=>'required',
            'title'=>'required'
        ]);
        if($validator->fails()){
            Toastr::error('Please enter title of room','Failed to create unit');
            return redirect()->back();
        }
        try{
            $room = new Room();
            $room->room_type_id = $request->room_type_id;
            $room->title = $request->title;
            $room->status = "Active";
            $room->save();
            Toastr::success('Unit created.','Operation Success');
            return redirect()->back();
        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
    }

    public function edit(Request $request){
        try{
            $editRoom = Room::find($request->room_id);
            $view = view('admin.roomType.rooms.edit',compact('editRoom'))->render();
            return response()->json($view,200);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function update(Request $request){
        try{
            $room = Room::find($request->room_id);
            $room->title = $request->title;
            $room->update();
            Toastr::success('Unit updated','Operation Success');
            return redirect()->route('admin.roomType');
        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
    }

    public function delete(Request $request){
        $room = Room::find($request->room_id);
        if(!$room){
            Toastr::error('Room Not Found','Cannot Delete Room');
            return redirect()->back();
        }
        $id_key = 'room_id';

        $tables = tableList::getTableList($id_key);
        try {
            $delete_query = $room->delete();
            if ($delete_query) {
                Toastr::success('Room Unit has been deleted successfully', 'Operation Success');
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
