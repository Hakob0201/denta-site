<ul class="social-icons list-unstyled mb-0">
    @foreach(config('site.social') as $key => $config)
        @if($config)
            @if($key === 'facebook')
                    <li>
                        <a rel="noopener" target="_blank" href="{{ $config['href'] }}">
                            <i class="fab fa-{{ $key }}-f"></i>
                        </a>
                    </li>
                @else
                    <li>
                        <a rel="noopener" target="_blank" href="{{ $config['href'] }}">
                            <i class="fab fa-{{ $key }}"></i>
                        </a>
                    </li>
            @endif
        @endif
    @endforeach
</ul>
<!-- /.social-icons -->
