@section('amp')
    @if($amp)
        <link rel="canonical" href="{{ config('app.url') }}/{{$locale}}/article/{{ $article->id }}">
    @else
        <link rel="amphtml" href="{{ config('app.url') }}/{{$locale}}/article/amp/{{ $article->id }}">
    @endif
@stop

<div class="flex lg:block flex-col p-16 sm:px-0 lg:my-45">
    <div class="author-share order-last sticky pr-12 mb-26 lg:float-left flex flex-col text-16 text-primary-50">
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
    <div class="article-body text-primary-100 mx-auto">
        <h1 class="text-22 lg:text-28 font-semibold lg:mb-45">{{ $article->contents->title }}</h1>
        @if($article->layout_id === 2)
            @include('includes.articles.image', ['item' => $article, 'class' => 'article-image w-full lg:mb-45', 'type' => 'l-'])
        @endif
        {!! articleBody($article) !!}
        @include('includes.articles.tags', ['color' => 'orange', 'item' => $article])
    </div>
</div>
