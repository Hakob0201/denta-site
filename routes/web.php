<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');

    if (request()->has('noredirect')) {
        return response('ok');
    } else {
        return redirect()->back();
    }

});

Route::fallback(function () {
    return redirect('/' . App::getLocale()); //TODO set locale correctly
});

// Home
Route::get('/', 'HomeController@index')->name('home');

// Article
$articleLayouts = 'articles|videos|audios|photos';

Route::get('{layout}', 'ArticleController@index')->where('layout', $articleLayouts);
Route::get('{layout}/{category}', 'ArticleController@index')->where(['layout' => $articleLayouts, 'category' => '[A-Za-z(-]+']);

Route::get('{layout}/{year}/{month}/{day}', 'ArticleController@archive')->where(['layout' => $articleLayouts, 'year' => '[0-9]+', 'month' => '[0-9]+', 'day' => '[0-9]+']);
Route::get('{layout}/{category}/{year}/{month}/{day}', 'ArticleController@archive')->where(['layout' => $articleLayouts, 'category' => '[A-Za-z(-]+', 'year' => '[0-9]+', 'month' => '[0-9]+', 'day' => '[0-9]+']);

Route::get('tag/{slug}', 'ArticleController@byTag')->name('tag');

Route::get('article/{article}', 'ArticleController@show')->where('article', '[0-9]+')->name('article');
Route::get('article/amp/{article}', 'ArticleController@ampShow')->where('article', '[0-9]+')->name('amp.article');
Route::get('article/mostviewed/{period}', 'ArticleController@mostRead');
Route::get('article/more/{page}', 'ArticleController@more');

// Search
Route::get('search', 'ArticleController@search');
Route::post('search/{conf}', 'ArticleController@search')->where('conf', 'catntag');

Route::get('feed', 'ArticleController@articleFeed');

// Author
//Route::get('authors', 'AuthorController@index');
//Route::get('author/{author}', 'AuthorController@show')->where('author', '[0-9]+')->name('author');

// Tag
//Route::get('tag/{tag}', 'TagController@index')->name('tag');

// Rss
Route::get('rss', 'ArticleController@rss');
Route::get('rss/google', 'ArticleController@rssGoogle');
Route::get('rss/yandex', 'ArticleController@rssYandex');
Route::get('/sitemap.txt', function () {
    return view('pages.sitemap', ['articles' => App\Article::all()]);
});

// Pages
Route::get('{path}', 'PageController@index');

if (App::environment('local')) {

//    Artisan::call('cache:clear');

    $path = storage_path() . '/logs/query.sql';
    DB::listen(function ($event) use ($path) {

        $sql = str_replace(['%', '?'], ['%%', '%s'], $event->sql);
        $sql = vsprintf($sql, $event->bindings);

        $time_now = date('Y-m-d H:i:s');
        $log      = $time_now . ' | ' . $sql . ' | ' . ($event->time / 1000) . ' second' . PHP_EOL . PHP_EOL;

        File::append($path, $log);

        //dump(vsprintf(str_replace(array('%', '?'), array('%%', '%s'), $event->sql),$event->bindings));
    });
}
