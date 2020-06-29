<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inclusion extends Model
{
    use Sluggable;
    use SoftDeletes;
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