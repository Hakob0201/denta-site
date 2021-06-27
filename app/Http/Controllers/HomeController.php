<?php

namespace App\Http\Controllers;

use MetaTag;

class HomeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $feed        = app('App\Http\Controllers\ArticleController')->articleFeed();
        $mostRead    = app('App\Http\Controllers\ArticleController')->articleMostRead();
        $headlines   = app('App\Http\Controllers\ArticleController')->articleHeadlines();
        $cats        = array_values(config('site.home.structure'));
        $page        = 0;   

        MetaTag::setTags([
            'title' => __('main.meta.title'),
            'description' => __('main.meta.description'),
        ]);

        return view('pages.home', compact('feed', 'mostRead', 'headlines', 'cats', 'page'));
    }
}
