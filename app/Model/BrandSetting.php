<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BrandSetting extends Model
{
    protected $fillable = ['brand_id', 'key', 'value'];

    public function brand(){

        return $this->belongsTo(Brand::class, 'brand_id', 'id');

    }
}
