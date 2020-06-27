<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iconable extends Model
{
    protected $fillable = ['icon_id', 'iconable_id', 'iconable_type'];

    public function iconable()
    {
        return $this->morphTo();
    }
}
