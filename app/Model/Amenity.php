<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Amenity extends Model
{
    use Sluggable;
    protected $fillable = ['title', 'slug', 'status', 'description'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }



    public function roomTypes(){

        return $this->belongsToMany(RoomType::class, 'amenity_room_type', 'amenity_id');

    }

    public function icon()
    {
        return $this->morphOne('App\Amenity', 'iconable');
    }
}
