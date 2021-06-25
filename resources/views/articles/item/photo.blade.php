@extends('layouts.' . ($amp ? 'amp' : 'app'))
@section('amp')
    @if($amp)
        <link rel="canonical" href="{{ config('app.url') }}/{{$locale}}/article/{{ $article->id }}">
    @else
        <link rel="amphtml" href="{{ config('app.url') }}/{{$locale}}/article/amp/{{ $article->id }}">
    @endif

@stop
@section('content')
    <article class="sm:px-16 relative">
        <div class="container px-16">
            <div class="relative">
                <div class="lg:absolute inset-0 overflow-hidden lg:bg-black lg:bg-opacity-30">
                    <div class="lg:absolute bottom-0 lg:p-26 text-15 text-primary-100 lg:text-white">
                        <p class="hidden lg:flex lg:text-primary-20">
                            @if(isset($amp))
                                <amp-img class="mr-12" src="/assets/svg/photo-20.svg" alt="Photo"
                                         width="22"
                                         height="20">
                                </amp-img>
                            @else
                                <img class="mr-12" src="/assets/svg/photo-20.svg" alt="Photo">
                            @endif
                            {{ $article->images->count() }} Images
                        </p>
                        <h1 class="text-20 my-12 lg:mb-45">{{ $article->contents->title }}</h1>
                        <time class="relative-date long block mb-16 lg:m-0"
                              datetime="{{ dateF($article->contents->datetime_at) }}"></time>
                    </div>
                </div>
                @include('includes.articles.image', ['item' => $article, 'class' => 'article-image w-full', 'type' => 'l-'])
            </div>
            <div class="author-share order-last pr-12 mb-26 lg:float-left flex flex-col text-16 text-primary-50">
                <time class="relative-date long"
                      datetime="{{ dateF($article->contents->datetime_at) }}">{{ $article->contents->datetime_at }}</time>
                @foreach($article->authors as $author)
                    <span class="mt-16">{{ $author->fullname }}</span>
                    <span>{{ $author->position }}</span>
                @endforeach
                @if(!isset($amp))
                    <span class="lg:mt-30 print hidden lg:block" onclick="window.print()">
                <img src="/assets/svg/print-50.svg" alt="Print">
        </span>
                @endif
                <div class="article-share down lg:mt-30 cursor-pointer">
                    @if(isset($amp))
                        <amp-img class="hidden  print lg:block" src="/assets/svg/rss-50.svg" alt="Rss"
                                 width="25"
                                 height="28">
                        </amp-img>
                    @else
                        <img class="hidden lg:block article-share-img" src="/assets/svg/rss-50.svg" alt="Rss">
                    @endif
                    <div class="mt-16">
                        @include('includes.share')
                    </div>
                </div>
            </div>
            <div class="article-body text-primary-100 ml-auto lg:pt-45">
                {!! articleBody($article) !!}
                @include('includes.articles.tags', ['color' => 'orange', 'item' => $article])
            </div>
            <div class="magnific-popup pool sm:p-0">
                @foreach($article->images as $image)
                    <a class="drop" target="_blank" href="/storage{{ $image->url . 'l-' . $image->name }}">
                        @if(isset($amp))
                            <amp-img class="article-image" src="/storage{{ $image->url . 'l-' . $image->name }}"
                                     alt="{{ $image->title }}"
                                     width="1280"
                                     height="638"
                                     layout="responsive"
                            >
                            </amp-img>
                        @else
                            <img class="article-image" src="/storage{{ $image->url . 'l-' . $image->name }}"
                                 alt="{{ $image->title }}">
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </article>
@stop
@section('schema')
    @include('includes.microdata.item')
@stop
