@extends('layouts.app')

@section('content')

    <section class="px-16 mb-16 lg:my-45 ">
        <div class="container justify-between lg:flex">
            @include('includes.articles.nav')
            <div class="w-full inf-scroll" data-page="{{ ($page ? $page + 1 : 2) . (request()->get('q') ? '&q=' . request()->get('q') : '') }}">
                @include('articles.list.' . $view)

                @if($articles->count() === 19)
                    @include('includes.load-more')
                @endif
            </div>
        </div>
    </section>
@stop

@section('schema')
    @include('includes.microdata.items')
@stop
