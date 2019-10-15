<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = [
        'name',
        'price',
        'description',
        'published_at',
        'images',
    ];

    public $dates = ['published_at'];

    public $casts = [
        'images' => 'json',
        'price' => 'integer',
    ];

    public function getImagesAttribute($images)
    {
        foreach(json_decode($images) as $image) {
            $imageUrls[] = asset('api/' . $image);
        }

        return $imageUrls;
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}
