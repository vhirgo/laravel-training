<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $images = [];
    foreach (range(1, 5) as $index) {
        $images[] = 'https://placehold.it/640x480?text=Image+' . $index;
    }

    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraphs(16, true),
        'price' => round($faker->numberBetween(100000, 100000000), -4),
        'published_at' => $faker->randomElement([now(), null]),
        'images' => $images,
    ];
});
