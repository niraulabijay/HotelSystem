<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Imageable extends Model
{
    protected $fillable = ['image_id', 'imageable_id', 'imageable_type', 'is_main'];

    public function imageable()
    {
        return $this->morphTo();
    }
}
