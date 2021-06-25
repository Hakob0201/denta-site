@foreach($items as $item)
    @if((isset($last) && $last !== $item->contents->date_at) || (!isset($last) && $page != 0))
        <time class="relative-date short sticky block bg-white z-10 text-15 text-primary-50 border border-light" datetime="{{ dateF($item->contents->date_at) }}">{{ $item->contents->date_at }}</time>
    @endif
    <a class="flex py-16 lg:py-0 border-t border-primary-20 border-opacity-20 lg:border-opacity-0 @if($item->contents->marked) font-semibold @endif" href="/{{ $locale }}/article/{{ $item->id }}">
        @include('includes.articles.image', ['type' => 't-', 'class' => 'feed-img hidden lg:block flex-shrink-0'])
        @if(is_null($item->image))
            <div class="feed-img hidden lg:block flex-shrink-0"></div>
        @endif
        <div class="flex flex-col space-y-12 ml-12 pr-12 mr-12 @if($item->contents->marked) border-r-2 border-orange @endif text-primary-50 font-medium">
            <span>{{ date("H:i", strtotime($item->contents->datetime_at)) }}</span>
            @if($item->contents->live)
                <span class="live flex items-center justify-center text-12 text-white bg-red rounded uppercase">Live</span>
            @elseif($layouts['article'][$item->layout_id] != 'article')
                <img class="object-contain" src="/assets/svg/{{ $layouts['article'][$item->layout_id] }}-red.svg" alt="{{ $layouts['article'][$item->layout_id] }}">
            @endif
        </div>
        <h2 class="text-primary-100 h-full">{{ $item->contents->title }}</h2>
    </a>
    @php
        $last = $item->contents->date_at;
    @endphp
@endforeach
