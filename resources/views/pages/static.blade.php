@extends('layouts.app')

@section('content')

<section class="px-16 pt-45">
    <div class="container lg:flex justify-between">
        <h2 class="text-24 mb-30 text-primary-50">{{ $page->title }}</h2>
        <div class="article-body static-body text-18 text-primary-100">
            {!! $page->body !!}
        </div>
    </div>
</section>

@stop
