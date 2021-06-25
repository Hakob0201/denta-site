<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LayoutSeeder::class);

        $categories = factory(App\Category::class, 10)->create();
        $authors    = factory(App\Author::class, 3)->create();
        $images     = factory(App\Image::class, 10)->create();
        $tags       = factory(App\Tag::class, 30)->create();

        factory(App\Article::class, 80)->create()->each(function ($article) use ($categories, $tags, $authors, $images) {
            foreach (config('language.locales') as $key => $item) {
                $content = $article->contents()->save(factory(App\ArticleContent::class)->make(['id' => $article->id, 'locale' => $key]));

                if (rand(1, 4) == 4) {
                    $article->headlines()->save(factory(App\ArticleHeadline::class)->make(['layout_id' => $article->layout_id, 'title' => $content->title, 'anons' => $content->anons, 'datetime_at' => $content->datetime_at, 'locale' => $key]));
                }
            }
            $article->views()->save(factory(App\ArticleView::class)->make());
            $article->images()->attach($images->random(rand(1, 4))->pluck('id')->toArray(), ['main' => 1]);
            $article->categories()->attach($categories->random(rand(1, 3))->pluck('id')->toArray());
            $article->authors()->attach($authors->random(1)->pluck('id')->toArray());
            $article->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray(), ['locale' => 'hy']);
        });
    }
}
