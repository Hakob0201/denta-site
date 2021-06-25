<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ArticleView;
use Faker\Generator as Faker;

$factory->define(ArticleView::class, function (Faker $faker) {
    return [
        'locale' => 'hy',
        'views'  => $faker->numberBetween(0, 10000),
    ];
});
