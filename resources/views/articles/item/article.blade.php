@extends('layouts.' . ($amp ? 'amp' : 'app'))

@section('content')

    <article class="sm:px-16 pb-45">
        <div class="container">
            @if($article->layout_id === 1)
                @include('includes.articles.image', ['item' => $article, 'class' => 'article-image w-full lg:mb-45', 'type' => 'l-'])
            @endif
            @include('articles.item.body')
        </div>
    </article>

@stop

@section('schema')
    @include('includes.microdata.item')
@stop
