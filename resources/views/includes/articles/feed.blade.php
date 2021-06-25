<div class="feed inf-scroll @if(!isset($home)) lg:hidden @endif transition duration-300 transform -translate-y-full my-45 py-45 lg:my-0 lg:py-0 lg:translate-y-0 fixed inset-0 bg-white lg:bg-none opacity-0 z-10 lg:opacity-100 lg:relative lg:space-y-22 custom-scroll flex-1" data-page="{{ ($page ? $page + 1 : 2) . (request()->get('q') ? '&q=' . request()->get('q') : '') }}" data-inline="true">
    @include('includes.articles.feed-items')
    @if(count($items) == 19)
        @include('includes.load-more')
    @endif
</div>
