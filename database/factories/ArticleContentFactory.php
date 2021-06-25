<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\Layout;
use App\ArticleContent;
use Faker\Generator as Faker;

$factory->define(ArticleContent::class, function (Faker $faker, $article) {
    $date = $faker->date();
    $time = $faker->time();

    return [
        'title'       => $faker->realText(100),
        'anons'       => $faker->realText(200),
        'text'        => $faker->realText(400),
        'video'       => Layout::find(Article::withoutGlobalScopes()->find($article['id'])->layout_id)->layout_key == 'video' ? '<iframe width="560" height="315" src="https://www.youtube.com/embed/lBhbPPsQhio" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' : null,
        'live'        => $faker->boolean(10) ? 1 : 0,
        'marked'      => $faker->boolean(30) ? 1 : 0,
        'date_at'     => $date,
        'onoff'       => 1,
        'time_at'     => $time,
        'datetime_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
    ];
});
