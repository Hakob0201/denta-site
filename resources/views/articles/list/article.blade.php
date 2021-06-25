<div class="cat-articles flex-1 ml-auto">
    @forelse($articles as $item)
        @if(((isset($last) && date('d', strtotime($item->contents->datetime_at)) != $last) || $loop->first) && $last = date('d', strtotime($item->contents->datetime_at)))
            @if(!$loop->first)
                </div>
                </div>
            @endif
                <div class="px-16 py-22 lg:py-45 lg:px-30 mb-30 bg-white shadow">
                    <h3 class="relative-date date text-20 lg:text-24 text-orange font-semibold lg:mx-30 mb-16" datetime="{{ dateF($item->contents->datetime_at) }}"></h3>
                    <div class="divide-y divide-primary-20 sm:divide-opacity-0 lg:divide-opacity-20 divide-opacity-50 grid grid-cols-6 sm:gap-16 lg:gap-0">
        @endif
        <div class="flex flex-col-reverse space-y-22 lg:space-y-0 lg:flex-row lg:py-30 lg:mx-30 justify-between text-primary-100 col-span-6 sm:col-span-3 lg:col-span-6">
            <time class="relative-date flex my-16 lg:mt-0 space-x-12 lg:space-x-0 lg:block text-orange lg:text-primary-50 whitespace-no-wrap mr-45" datetime="{{ dateF($item->contents->datetime_at) }}">{{ $item->contents->datetime_at }}</time>
            <div class="flex-1 space-y-12 lg:px-45">
                <a href="/{{ $locale }}/article/{{ $item->id }}">
                    <h2 class="text-18 lg:text-20 font-semibold">
                        {{ $item->contents->title }}
                    </h2>
                </a>
                @include('includes.articles.tags', ['color' => 'primary-50'])
            </div>
            <a href="/{{ $locale }}/article/{{ $item->id }}">
                @include('includes.articles.image', ['type' => 's-', 'class' => 'w-full lg:w-auto'])
            </a>
        </div>
    @empty
        <h1 class="text-primary-50 text-28 mb-45 col-span-6">{{ __('main.no-articles') }}</h1>
        <div>
            <div>
    @endforelse
        </div>
    </div>
</div>

