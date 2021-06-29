@extends('layouts.app')

@section('content')

    <!-- ====================== Blog Grid ========================= -->
    <section class="blog-grid @if(!isset($home)) lg:hidden @endif">
        <div class="container">
            <div class="row"  data-page="{{ ($page ? $page + 1 : 2) . (request()->get('q') ? '&q=' . request()->get('q') : '') }}">
                @include('articles.list.article')
                @if($articles->count() === 19)
                    @include('includes.load-more')
                @endif
            </div>
        </div>
    </section>

@stop
