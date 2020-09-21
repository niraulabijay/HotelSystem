<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Inclusion extends Model
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

        return $this->belongsToMany(RoomType::class, 'inclusion_room_type', 'inclusion_id');

    }

    public function icon()
    {
        return $this->morphOne('App\Inclusion', 'iconable');
    }
}
