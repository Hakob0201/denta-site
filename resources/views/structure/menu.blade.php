<div
    class="menu-body fixed z-20 lg:z-50 inset-0 flex flex-col transition duration-300 transform -translate-y-full opacity-0 print:hidden">
    <div
        class="menu-body-nav absolute hidden lg:flex bottom-0 lg:bottom-auto lg:top-0 left-0 right-0 items-center z-20">
        <div class="absolute ml-22 lg:ml-0">
            <div class="circle menu cursor-pointer rounded-full bg-white ml-22 p-12">
                <img src="/assets/svg/close-100.svg" alt="Close">
            </div>
        </div>
        <div class="logo-wrap text-12">
            @include('includes.logo')
        </div>
    </div>
    <div class="menu-body-main grid grid-cols-6 overflow-auto bg-light">
        <div class="menu-custom col-span-6 lg:col-span-2 lg:bg-primary-100 flex justify-center">
            <div class="flex flex-col w-full lg:w-auto menu-content">
                <div class="open-sesame text-primary-20 text-18 font-medium bg-primary-100 p-16 mb-16 lg:p-0 lg:mb-0">
                    <span class="door ignore-hover block truncate">
                        <span class="pr-12">{{ __('main.journalism') }}</span>
                        <img class="pb-px mb-px inline lg:hidden" src="/assets/svg/arrow-right.svg" alt="Arrow">
                    </span>
                    <div class="sesame flex flex-col">
                        @foreach($categories->where('layout_id', $layouts['category']['key']['custom']) as $key => $cat)
                            <a class="hover-orange mt-30"
                               href="/{{ $locale }}/articles/{{ $cat->category_key }}">{{ $cat->category_name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="mt-auto hidden lg:block">
                    <div class="flex flex-col text-primary-50 space-y-16 mb-16">
                        @include('includes.contacts')
                    </div>
                    @include('includes.socials')
                </div>
            </div>
        </div>
        <div class="menu-news col-span-6 lg:col-span-4">
            <div class="flex menu-news-content flex-col px-30 lg:px-0 lg:flex-row justify-evenly overflow-hidden">
                <div class="cats flex flex-col text-primary-100 text-18 font-medium overflow-auto custom-scroll">
                    <a class="hover-orange mb-30" href="/{{ $locale }}/articles">{{ __('main.articles') }}</a>
                    @foreach($categories->where('layout_id', $layouts['category']['key']['article']) as $key => $cat)
                        <a class="hover-orange mb-30"
                           href="/{{ $locale }}/articles/{{ $cat->category_key }}">{{ $cat->category_name }}</a>
                    @endforeach
                </div>
                <div class="cats order-first lg:order-last flex flex-col text-primary-100 font-medium">
                    @foreach($layouts['category']['key'] as $key => $value)
                        @if(!in_array($key, ['article', 'custom']))
                            <div class="mb-30">
                                <a class="hover-orange flex items-center space-x-12 text-18"
                                   href="/{{ $locale }}/{{ $key }}s">
                                    <img class="img-50" src="/assets/svg/{{ $key }}-50.svg" alt="{{ $key }}">
                                    <span>{{ __('main.' . $key . 's') }}</span>
                                </a>
                                @if($categories->where('layout_id', $value)->count() > 0)
                                    <div class="sub-cat flex flex-col mt-30 ml-22 lg:ml-0">
                                        @foreach($categories->where('layout_id', $value) as $catKey => $cat)
                                            <a class="hover-orange text-primary-50 border-l-2 border-orange text-16"
                                               href="/{{ $locale }}/{{ $key }}s/{{ $cat->category_key }}">{{ $cat->category_name }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div
    class="black-bg hidden lg:block fixed z-20 top-0 left-0 right-0 bg-black opacity-0 h-screen transition duration-300 pointer-events-none"></div>
