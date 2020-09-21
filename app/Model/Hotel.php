<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Hotel extends Model implements HasMedia
{
    use HasMediaTrait;
    use Sluggable;

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

    //Mediacollection to hold only one file
    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('hotel_feature')
            ->singleFile();
    }

    //return hotel feature image
    public function featureImage()
    {
        return $this->getFirstMedia('hotel_feature');
    }

    //Register Media conversion
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('feature-thumb')
              ->width(350)
              ->height(200)
              ->sharpen(10);
    }
}
