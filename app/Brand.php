<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Brand extends Model implements HasMedia
{
    use HasMediaTrait;
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



    public function brandSettings(){

        return $this->hasMany(BrandSetting::class, 'brand_id', 'id');

    }
    public function hotels(){

        return $this->hasMany(Hotel::class, 'brand_id', 'id');

    }

    public function icon()
    {
        return $this->morphOne('App\Brand', 'iconable');
    }

    public function logo()
    {
        return $this->getFirstMedia('brand_logo');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('logo-thumb')
              ->width(250)
              ->height(100)
              ->sharpen(10);
    }
}
