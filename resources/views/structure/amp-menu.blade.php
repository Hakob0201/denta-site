<amp-sidebar id="sidebar1" layout="nodisplay" style="max-width: 100vw;right: 0;margin: auto;height: calc(100vh - 140px);margin-top: 70px;">
    <amp-nested-menu layout="fill">
        <div class="menu-body-main grid grid-cols-6 overflow-auto bg-light">
            <div class="menu-custom col-span-6 lg:col-span-2 lg:bg-primary-100 flex justify-center">
                <div class="flex flex-col w-full lg:w-auto">
                    <div class="open-sesame text-primary-20 text-18 font-medium bg-primary-100 p-16 mb-16 lg:p-0 lg:mb-0">
                        <a class="door ignore-hover block truncate" href="#">
                            <span class="pr-12">{{ __('main.journalism') }}</span>
                            @if(isset($amp))
                                <amp-img class="pb-px mb-px inline lg:hidden" src="/assets/svg/arrow-right.svg" alt="Arrow"
                                         width = "30"
                                         height = "30">
                                </amp-img>
                            @else
                                <img class="pb-px mb-px inline lg:hidden" src="/assets/svg/arrow-right.svg" alt="Arrow"
                            @endif
                        </a>
                        <div class="sesame flex flex-col">
                            @foreach($categories->where('layout_id', $layouts['category']['key']['custom']) as $key => $cat)
                                <a class="hover-orange mt-30" href="/{{ $locale }}/articles/{{ $cat->category_key }}">{{ $cat->category_name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-auto icon-menu hidden lg:block">
                        <div class="flex flex-col text-primary-50 space-y-16 mb-16">
                            @include('includes.contacts')
                        </div>
                        @include('includes.socials')
                    </div>
                </div>
            </div>
            <div class="menu-news col-span-6 lg:col-span-4">
                <div class="flex flex-col px-30 lg:px-0 lg:flex-row justify-evenly overflow-hidden">
                    <div class="cats flex flex-col text-primary-100 text-18 font-medium overflow-auto custom-scroll">
                        <a class="hover-orange mb-30" href="/{{ $locale }}/articles">{{ __('main.articles') }}</a>
                        @foreach($categories->where('layout_id', $layouts['category']['key']['article']) as $key => $cat)
                            <a class="hover-orange mb-30" href="/{{ $locale }}/articles/{{ $cat->category_key }}">{{ $cat->category_name }}</a>
                        @endforeach
                    </div>
                    <div class="cats order-first lg:order-last flex flex-col text-primary-100 font-medium">
                        @foreach($layouts['category']['key'] as $key => $value)
                            @if(!in_array($key, ['article', 'custom']))
                                <div class="mb-30">
                                    <a class="hover-orange flex items-center space-x-12 text-18" href="/{{ $locale }}/{{ $key }}s">
                                        @if(isset($amp))
                                            <amp-img class="img-50" src="/assets/svg/{{ $key }}-50.svg" alt="{{ $key }}"
                                                     width = "30"
                                                     height = "{!! $key === 'photo' ? '26' : '30' !!}">
                                            </amp-img>
                                        @else
                                            <img class="img-50" src="/assets/svg/{{ $key }}-50.svg" alt="{{ $key }}">
                                        @endif
                                        <span>{{ __('main.' . $key . 's') }}</span>
                                    </a>
                                    @if($categories->where('layout_id', $value)->count() > 0)
                                        <div class="sub-cat flex flex-col mt-30 ml-22 lg:ml-0">
                                            @foreach($categories->where('layout_id', $value) as $catKey => $cat)
                                                <a class="hover-orange text-primary-50 border-l-2 border-orange text-16" href="/{{ $locale }}/{{ $key }}s/{{ $cat->category_key }}" style="padding: .375rem .75rem;">{{ $cat->category_name }}</a>
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

    </amp-nested-menu>
</amp-sidebar>
