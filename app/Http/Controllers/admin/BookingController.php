<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\BookingRepository;
use App\Repositories\HotelRepository;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(BookingRepository $bookingRepository, HotelRepository $hotelRepository)
    {
        $this->bookingRepo = $bookingRepository;
        $this->hotelRepo = $hotelRepository;
    }

    public function index(){

        return $this->bookingRepo->all();
    }

    public function new(){
        $hotel = $this->hotelRepo->getAuthHotel();
        return view('admin.bookings.new',compact('hotel'));
    }

    public function checkAvailable(Request $request){
        try{
            $hotel = $this->hotelRepo->findById($request->hotel_id);
            $roomTypes = $hotel->roomTypes;
            $availableRooms = $this->bookingRepo->availableRooms($request->all());
            foreach($roomTypes as $roomType){
                $roomType->available_rooms = $availableRooms->where('room_type_id',$roomType->id);
                if($roomType->available_rooms->count() == 0){
                    $roomType->is_available = 0;
                }else{
                    $roomType->is_available = 1;
                }
            }
            // dd($roomTypes[0]);
            $roomTypes = $roomTypes->where('is_available',1);
            $persons = $request->persons;
            $view = view('admin.bookings.roomTypesChoice',compact('roomTypes','persons'))->render();
            return response()->json($view, 200);
        }catch(\Exception $e){
            $msg = $e->getMessage();
            $view = view('admin.errors.ajaxAlert',compact('msg','e'))->render();
            return response()->json($view,200);
        }
    }

    public function proceedBooking(Request $request){
        dd($request);
    }
}
