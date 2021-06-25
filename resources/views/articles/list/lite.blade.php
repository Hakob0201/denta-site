@extends('layouts.app')

@section('content')

    <section class="px-16 mb-16 lg:my-45 ">
        <div class="container justify-between lg:flex">
            <div class="cat-cal mt-16 lg:mt-0 lg:sticky lg:float-left self-start pr-16">
                <h1 class="text-primary-100 text-24">{{ __('main.' . $view) }}</h1>
                <a class="category block my-30 text-15 rounded border mb-12 overflow-hidden truncate text-orange border-orange">{{ $view == 'tag-result' ? $tag->tag_name : request()->get('q') }}</a>
            </div>
            <div class="inf-scroll w-full" data-page="{{ ($page ? $page + 1 : 2) . (request()->get('q') ? '&q=' . request()->get('q') : '') }}">
                @include('articles.list.article')
                @if($articles->count() === 19)
                    @include('includes.load-more')
                @endif
            </div>
        </div>
    </section>

@stop
