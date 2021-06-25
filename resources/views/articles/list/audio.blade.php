<div class="cat-articles flex-1 grid grid-cols-6 sm:gap-16 lg:gap-0 ml-auto">
    @forelse($articles as $item)
        <div class="mb-30 bg-white shadow col-span-6 sm:col-span-3 lg:col-span-6">
            <div class="flex flex-col-reverse lg:flex-row justify-between lg:space-x-45 relative">
                <time class="relative-date flex lg:mt-0 space-x-12 lg:space-x-0 lg:block p-26 text-orange lg:text-primary-50 whitespace-no-wrap" datetime="{{ dateF($item->contents->datetime_at) }}">{{ $item->contents->datetime_at }}</time>
                <div class="p-26 flex-1 space-y-12">
                    <a href="/{{ $locale }}/article/{{ $item->id }}">
                        <h2 class="text-18 lg:text-20 text-primary-100 font-semibold">
                            {{ $item->contents->title }}
                        </h2>
                    </a>
                    @include('includes.articles.tags', ['color' => 'primary-50'])
                </div>
                @if($item->image)
                    <a class="relative" href="/{{ $locale }}/article/{{ $item->id }}">
                        @include('includes.articles.image', ['type' => 's-', 'class' => 'w-full lg:w-auto'])
                        <div class="absolute inset-0 lg:bg-black lg:bg-opacity-30 p-22">
                            <img src="/assets/svg/audio-white.svg" alt="Audio">
                        </div>
                    </a>
                @endif
            </div>
        </div>
    @empty
        <h1 class="text-primary-50 text-28 mb-45 col-span-6">{{ __('main.no-articles') }}</h1>
    @endforelse
</div>
