{{ config('app.url') . '/' . $locale }}
@foreach($layouts['category']['key'] as $key => $value)
    @if($key !== 'custom')
        {{ config('app.url') . '/' . $locale . '/' . $key . 's' }}
    @endif
@endforeach
@foreach($layouts['category']['key'] as $key => $value)
    @if($key !== 'custom' && $categories->where('layout_id', $value)->count() > 0)
        @foreach($categories->where('layout_id', $value) as $catKey => $cat)
            {{ config('app.url') . '/' . $locale . '/' . $key . 's/' . $cat->category_key }}
        @endforeach
    @endif
@endforeach
@foreach($tags as $value)
    {{ config('app.url') . '/' . $locale . '/tag/' . $value->tag_slug }}
@endforeach
@foreach($articles as $item)
    {{ config('app.url') . '/' . $locale . '/article/' . $item->id }}
@endforeach
