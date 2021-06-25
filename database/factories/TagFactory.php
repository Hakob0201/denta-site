<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    $tag_name['hy'] = $faker->word;
    $tag_name['ru'] = $faker->word;
    $tag_name['en'] = $faker->word;

    return [
        'tag_slug' => $faker->unique()->word,
        'tag_name' => json_encode($tag_name),
    ];
});
