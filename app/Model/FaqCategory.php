<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $table = "faq_categories";

    protected $fillable = [
        'title', 'slug',
        'status', 'description' //extra fields for future use if required
    ];
}
