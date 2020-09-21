<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HotelSetting extends Model
{
    protected $fillable = ['hotel_id', 'key', 'value'];

    public function hotel(){

        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');

    }
}
