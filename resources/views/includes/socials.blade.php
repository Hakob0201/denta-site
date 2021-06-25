<div class="socials flex space-x-12 lg:space-x-0">
    @foreach(config('site.social') as $key => $config)
        @if($config)
            <a class="hover-orange rounded flex justify-center items-center border border-primary-20 hover:border-orange border-opacity-0 hover:border-opacity-100"
               rel="noopener" target="_blank" href="{{ $config['href'] }}">
                @if(isset($amp))
                    <amp-img class="img-20" src="/assets/svg/{{ $key }}-20.svg" alt="{{ $key }}"
                             width="{{ $config['width']}}"
                             height="{{$config['height']}}"
                    >
                    </amp-img>
                @else
                    <img class="img-20" src="/assets/svg/{{ $key }}-20.svg" alt="{{ $key }}">
                @endif
            </a>
        @endif
    @endforeach
</div>
