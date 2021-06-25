<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "ItemList",
        "url": "{{ url()->current() }}",
        "numberOfItems": "{{ $articles->count() }}",
        @if($articles->count() > 0)
        "itemListElement": [
            @foreach($articles as $item)
            @if($loop->index > 0),@endif {
            "@type": "ListItem",
            "url": "{{ config('app.url') }}/{{ $locale }}/article/{{ $item->id }}",
            "position": {{ $loop->index }}
            }
@endforeach
        ],
        @endif
    "name": "{{ ($categories->firstWhere('category_key', $category) ? $categories->firstWhere('category_key', $category)->category_name : __('main.' . $view . 's')) . ' - ' . __('main.meta.title') }}"
    }
</script>

@include('includes.microdata.shared.organization')
