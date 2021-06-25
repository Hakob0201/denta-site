<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Layout;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $layouts = Layout::where('layout_type', 'category')->get();
    $category_name['hy'] = $faker->word;
    $category_name['ru'] = $faker->word;
    $category_name['en'] = $faker->word;

    return [
        'layout_id'  => $faker->optional($weight = 0.7, $layouts->first()->id)->randomElement($layouts->pluck('id')),
        'category_key'      => $faker->unique()->word,
        'category_name'     => json_encode($category_name),
        'visible'           => $faker->randomElement([0, 1]),
        'headline_visible'  => $faker->randomElement([0, 1]),
        'headline_position' => $faker->numberBetween(0, 99),
        'ordering'          => $faker->numberBetween(0, 99),
    ];
});
