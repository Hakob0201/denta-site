<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        if (env('APP_ENV') !== 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }
        Schema::defaultStringLength(191);

        $categories = getCategories();
        $layouts    = getLayouts();
        $currency   = getCurrency();
//        $banners    = getBanners();
        $tags       = getTags();
//        dd($layouts);
        app()->categories = $categories;
        app()->layouts    = $layouts;
        app()->currency   = $currency;
//        app()->authors    = $authors;
        app()->tags       = $tags;

        view()->share('categories', $categories);
        view()->share('layouts', $layouts);
        view()->share('currency', $currency);
//        view()->share('authors', $authors);
//        view()->share('banners', $banners);
        view()->share('tags', $tags);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
