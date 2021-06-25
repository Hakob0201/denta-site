<a class="logo inline-flex items-center text-primary-50" href="/{{ $locale }}">
    <div class="logo-desc text-right">
        {!! __('main.logo') !!}
    </div>
    @if(isset($amp))
        <amp-img src="/assets/svg/logo-mobile.svg" alt="Logo"
                 width="68"
                 height="47">
        </amp-img>
    @else
        <img src="/assets/svg/logo-mobile.svg" alt="Logo">
    @endif
</a>
