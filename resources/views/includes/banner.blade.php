@if($banner)
    <a class="banner flex mb-16 lg:mb-30 bg-white shadow" href="{{ $banner->link }}" rel="noopener" target="_blank">
        @if($banner->type === 'image')
            <img class="object-contain" src="/storage/azd/{{ $banner->id }}/{{ $banner->file }}" alt="banner">
        @else
            {!! $banner->code !!}
        @endif
    </a>
@endif
