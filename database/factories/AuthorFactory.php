<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use Faker\Generator as Faker;

$factory->define(Author::class, function (Faker $faker) {
    $fullname['hy'] = $faker->name;
    $fullname['ru'] = $faker->name;
    $fullname['en'] = $faker->name;
    $position['hy'] = $faker->sentence(2);
    $position['ru'] = $faker->sentence(2);
    $position['en'] = $faker->sentence(2);

    return [
        'fullname'   => json_encode($fullname),
        'email'      => $faker->unique()->safeEmail,
        'position'   => json_encode($position),
        'ordering'   => $faker->numberBetween(0, 99),
    ];
});
