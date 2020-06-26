<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = ['title', 'slug', 'brand_id', 'status', 'description'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }



    public function brand(){

        return $this->belongsTo(Brand::class, 'brand_id', 'id');

    }

    public function hotelSettings(){

        return $this->hasMany(HotelSetting::class, 'hotel_id', 'id');

    }

    public function roomTypes(){

        return $this->hasMany(RoomType::class, 'hotel_id', 'id');

    }


    public function icon()
    {
        return $this->morphOne('App\Hotel', 'iconable');
    }


    public function featureImage()
    {
        return $this->morphOne('App\Hotel', 'imageable')->where('is_main', 1);
    }


    public function images()
    {
        return $this->morphMany('App\Hotel', 'imageable')->where('is_main', 0);
    }
}
