@extends('layouts.' . ($amp ? 'amp' : 'app'))

@section('content')

    <article class="sm:px-16 pb-45">
        <div class="container">
            <div class="{!! $amp ? '' : 'video' !!} relative overflow-hidden">
                {!! $article->contents->video !!}
            </div>
            @include('articles.item.body')
        </div>
    </article>

@stop
@section('schema')
    @include('includes.microdata.item')
@stop
