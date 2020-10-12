<?php

namespace App\Repositories;

use App\Model\Booking;
use App\Model\Room;
use App\Model\RoomType;

class BookingRepository{

    public function all(){
        return Booking::where('status','Active')
            ->get()
            ->map(function($booking){
                return [
                    'title' => $booking->title,
                    'value' => $booking->value,
                ];
            });
    }

    //useful helper
    public function findById($id){
        $booking = Booking::where('id',$id)
            ->with('user')
            ->firstOrFail();
        return $this->format($booking);

    }

    public function bookingsByInterval($roomId, $checkIn, $checkOut){
        return Booking::where('room_id',$roomId)
            // ->where('status','<code>') // Check Status not cancelled or removed
            ->get();
    }

    public function availableRooms($data = []){
        // dd($roomType);
        $checkIn = $data['checkIn'];
        $checkOut = $data['checkOut'];
        $rooms = Room::whereHas('bookings', function ($q) use ($checkIn, $checkOut) {
            $q->where(function ($q2) use ($checkIn, $checkOut) {
                $q2->where('check_in', '>=', $checkOut)
                   ->orWhere('check_out', '<=', $checkIn);
            });
        })->orWhereDoesntHave('bookings')->get();
        return $rooms;

    }

    protected function format($booking){
        return [
            'title' => $booking->title,
            'value' => $booking->value,
            'created_at'=> $booking->created_at->diffForHumans(),
        ];
    }

}

