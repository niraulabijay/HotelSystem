<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
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

    public function featureImage()
    {
        return $this->morphOne('App\Brand', 'imageable')->where('is_main', 1);
    }
}
