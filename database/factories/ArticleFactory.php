<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\Layout;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    $layouts = Layout::where('layout_type', 'article')->get();
    return [
        'layout_id'  => $faker->optional($weight = 0.7, $layouts->first()->id)->randomElement($layouts->pluck('id')),
        'onoff'      => 1,
    ];
});
