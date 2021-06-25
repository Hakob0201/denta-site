<div class="text-center">
    <div class="load-more relative mx-auto inline-flex text-18 text-primary-50 items-center justify-center">
        @if(isset($amp))
            <amp-img class="icon absolute animate-spin mr-16 hidden" src="/assets/svg/loading.svg" alt="Loading"
                     width="30"
                     height="30">
            </amp-img>
        @else
            <img class="icon absolute animate-spin mr-16 hidden" src="/assets/svg/loading.svg" alt="Loading">
        @endif
        <span class="text">
            <span class="animate-pulse loading">{{ __('main.scroll.loading') }}</span>
            <span class="end hidden">{{ __('main.scroll.end') }}</span>
        </span>
        <span
           class="button hidden py-16 px-22 bg-primary-20 bg-opacity-60 border-primary-50 rounded cursor-pointer">
            <div class="load">
                <span class="more">{{ __('main.scroll.more') }}</span>
                <span class="loading animate-pulse hidden">{{ __('main.scroll.loading') }}</span>
            </div>
            <span class="end hidden">{{ __('main.scroll.end') }}</span>
        </span>
    </div>
</div>
