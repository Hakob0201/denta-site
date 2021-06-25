<div
    class="search mobile-move z-20 flex-shrink-0 fixed bottom-0 m-0 mr-22 lg:mr-0 lg:static lg:bg-black lg:bg-opacity-10 cursor-pointer flex items-center justify-center lg:ml-30 lg:border-l border-primary-50 border-opacity-10 print:hidden">
    @if(!isset($amp))
        <img src="/assets/svg/search-20.svg" alt="Search">
    @endif
</div>
<div
    class="search-body z-10 pt-45 lg:pt-0 inset-0 lg:bottom-auto fixed transition duration-300 transform -translate-y-full opacity-0 bg-primary-100 flex flex-col-reverse lg:flex-row justify-end lg:justify-between print:hidden">
    <div class="w-full flex bg-black bg-opacity-30 lg:bg-none">
        <label class="w-full" for="search">
            <input id="search"
                   class="search-input w-full pl-12 py-22 bg-none my-px outline-none rounded-none text-white"
                   type="text" name="search" value="" placeholder="&nbsp;&nbsp;&nbsp;{{ __('main.search') }}">
        </label>
        <a class="search-button ml-auto hover-orange mr-22 p-22 cursor-pointer flex items-center">
            @if(isset($amp))
                <amp-img class="img-20 serch" src="/assets/svg/search-20.svg" alt="Search"
                         width="30"
                         height="30">
                    </amp-img>
            @else
                <img class="img-20 serch" src="/assets/svg/search-20.svg" alt="Search">
            @endif
        </a>
    </div>
    <div
        class="search-result overflow-auto w-full order-first lg:fixed text-white lg:text-primary-100 lg:bg-white px-16 shadow grid grid-cols-12 lg:gap-16">
        <div class="articles col-span-12 lg:col-span-6 hidden">
            <h2 class="px-16 my-16 text-22 border-l-4 border-primary-20 border-opacity-50">{{ __('main.search-articles') }}</h2>
            <div class="divide-y divide-primary-20 divide-opacity-50 overflow-auto custom-scroll">

            </div>
            <span class="flavor flex items-center px-12 py-16">
                <span class="fail">{{ __('main.no-articles') }}</span>
                <span class="load hidden flex items-center animate-pulse">
                     @if(isset($amp))
                        <amp-img class="img-20" src="/assets/svg/loading.svg" alt="Search"
                                 width="30"
                                 height="30">
                    </amp-img>
                    @else
                        <img class="animate-spin mr-16" src="/assets/svg/loading.svg" alt="Loading">
                    @endif
                </span>
            </span>
        </div>
        <div class="categories col-span-12 lg:col-span-3 hidden">
            <h2 class="px-16 my-16 text-22 border-l-4 border-primary-20 border-opacity-50">{{ __('main.categories') }}</h2>
            <div class="divide-y divide-primary-20 divide-opacity-50 overflow-auto custom-scroll"></div>
        </div>
        <div class="tags col-span-12 lg:col-span-3 hidden">
            <h2 class="px-16 my-16 text-22 border-l-4 border-primary-20 border-opacity-50">{{ __('main.tags') }}</h2>
            <div class="divide-y divide-primary-20 divide-opacity-50 overflow-auto custom-scroll"></div>
        </div>
    </div>
</div>
