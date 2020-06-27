<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use Sluggable;
    use SoftDeletes;
    protected $fillable = ['title', 'slug', 'status', 'description', 'hotel_id', 'no_of_guest', 'price'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    public function hotel(){

        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');

    }

    public function amenities(){

        return $this->belongsToMany(Amenity::class, 'amenity_room_type', 'room_type_id');

    }

    public function inclusions(){

        return $this->belongsToMany(Amenity::class, 'inclusion_room_type', 'room_type_id');

    }

    public function icon()
    {
        return $this->morphOne('App\RoomType', 'iconable');
    }


    public function featureImage()
    {
        return $this->morphOne('App\RoomType', 'imageable')->where('is_main', 1);
    }


    public function images()
    {
        return $this->morphMany('App\RoomType', 'imageable')->where('is_main', 0);
    }
}
