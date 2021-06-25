<div class="open-sesame cat-cal z-10 lg:pr-16 sticky self-start px-16 pt-16 -mx-16 -mt-16 mb-px bg-lighter lg:bg-none lg:mr-0">
    <div class="bg-white shadow cursor-pointer mb-12 lg:mb-30 inline-block relative rounded">
        <img class="p-16 z-10" src="/assets/svg/calendar.svg" alt="Calendar">
        <input class="datepicker-i z-20 absolute top-0 left-0 right-0 bottom-0 w-full h-full bg-none cursor-pointer border-none outline-none text-primary-100 text-opacity-0" type="text" readonly data-language="{{ $locale }}" data-date-format="yyyy/mm/dd" data-position="bottom left" data-category="{{ $category }}" data-type="{{ $view . 's' }}"/>
    </div>
    <a class="door by-cats ignore-hover lg:hidden whitespace-no-wrap inline-flex float-right justify-between ml-16 mb-12 p-22 bg-white shadow rounded items-center text-18 text-primary-50" href="javascript:">
        {{ $categories->firstWhere('category_key', $category) ? $categories->firstWhere('category_key', $category)->category_name : __('main.' . $view . 's') }}
        <img src="/assets/svg/arrow-bottom.svg" alt="Arrow">
    </a>
    <div class="sesame flex flex-wrap lg:flex-col">
        <a class="category hover-orange mr-12 lg:mr-0 text-15 rounded border mb-12 truncate hover:border-orange @if($category == 'all-articles') text-orange border-orange" href="#" @else text-primary-50 border-primary-50" href="/{{ $locale }}/{{ $view }}s/" @endif>{{ __('main.' . $view . 's') }}</a>
        @foreach($categories as $cat)
            @if($layouts['category'][$cat->layout_id] == $view)
                <a class="category hover-orange mr-16 lg:mr-0 text-15 rounded border mb-12 truncate hover:border-orange @if($cat->category_key == $category) text-orange border-orange" @else text-primary-50 border-primary-50" href="/{{ $locale }}/{{ $view }}s/{{ $cat->category_key }}" @endif>
                    {{ $cat->category_name }}
                </a>
            @endif
        @endforeach
    </div>
</div>
