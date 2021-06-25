<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\ArticleHeadline;
use Faker\Generator as Faker;

$factory->define(ArticleHeadline::class, function (Faker $faker) {
    return [
        'category_key'  => Category::where('headline_visible', 1)->inRandomOrder()->first()->category_key,
        'ordering'      => $faker->numberBetween(0, 99),
    ];
});
