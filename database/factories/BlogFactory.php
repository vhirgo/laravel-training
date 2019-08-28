<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'content' => $faker->paragraph(6),
        'published_at' => $faker->randomElement([now(), null])
    ];
});
