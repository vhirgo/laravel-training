<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public $fillable = [
        'title', 'content', 'published_at',
    ];

    public $dates = [
        'published_at',
    ];

    public $casts = [];
}
