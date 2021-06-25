<div class="cat-videos flex-1 grid grid-cols-6 gap-30 ml-auto mb-30">
    @forelse($articles as $item)
        <a class="relative @if($loop->first) col-span-6 @else col-span-6 sm:col-span-3 @endif" href="/{{ $locale }}/article/{{ $item->id }}">
            @include('includes.articles.image', ['class' => 'w-full h-full', 'type' => ($loop->first ? 'l-' : '')])
            <div class="absolute overflow-hidden inset-0 bg-black bg-opacity-30 @if($loop->first) pt-12 px-12 @endif">
                <img class="hidden lg:block absolute m-26 z-10" src="/assets/svg/video-white.svg" alt="Video">
                <div class="content text-white absolute bottom-0 p-12 lg:p-26">
                    <h2 class="mb-12 lg:mb-22 text-18 @if($loop->first) lg:text-24 @else lg:text-20 @endif">{{ $item->contents->title }}</h2>
                    <time class="relative-date long text-15" datetime="{{ dateF($item->contents->datetime_at) }}">{{ $item->contents->datetime_at }}</time>
                </div>
            </div>
        </a>
    @empty
        <h1 class="text-primary-50 text-28 mb-45 col-span-6">{{ __('main.no-articles') }}</h1>
    @endforelse
</div>
