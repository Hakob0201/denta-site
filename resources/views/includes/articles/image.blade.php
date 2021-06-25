@if($item->image)
    @if(isset($amp))
        <amp-img layout="responsive" @isset($class) class="{{ $class }}" @endif src="/storage{{ $item->image->url . (isset($type) ? $type : '') . $item->image->name }}" alt="{{ $item->contents ? $item->contents->title : $item->title }}"
                 width = "740"
                 height = "490">
        </amp-img>
    @else
        <img @isset($class) class="{{ $class }}" @endif src="/storage{{ $item->image->url . (isset($type) ? $type : '') . $item->image->name }}" alt="{{ $item->contents ? $item->contents->title : $item->title }}">
    @endif
@endif
