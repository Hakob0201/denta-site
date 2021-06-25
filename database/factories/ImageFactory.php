<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(20),
        'url'   => 'no',
        'name'  => 'no',
    ];
});

$factory->afterCreating(Image::class, function ($image, $faker) {
    $fpath = storage_path('app') . '/public/static/articles/' . $image->id;
    File::makeDirectory($fpath, $mode = 0777, true, true);
    $name = $faker->image($fpath, '300', '300', null, false);

    $thumb = $faker->image($fpath, '94', '70', null, false);
    $small = $faker->image($fpath, '200', '200', null, false);
    $wide = $faker->image($fpath, '625', '400', null, false);
    $big = $faker->image($fpath, '1280', rand(400, 1080), null, false);

    rename($fpath . '/' . $thumb, $fpath . '/t-' . $name);
    rename($fpath . '/' . $small, $fpath . '/s-' . $name);
    rename($fpath . '/' . $wide, $fpath . '/w-' . $name);
    rename($fpath . '/' . $big, $fpath . '/l-' . $name);

    $image->url     = '/static/articles/' . $image->id . '/';
    $image->name    = $name;
    $image->save();
});
