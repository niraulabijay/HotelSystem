<?php

namespace App\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use Sluggable;

    protected $table = "faq_categories";

    protected $fillable = [
        'title', 'slug',
        'status', 'description' //extra fields for future use if required
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function faqs(){
        return $this->hasMany(Faq::class,'faq_category_id');
    }


}
