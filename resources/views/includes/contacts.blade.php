<div class="col-sm-12 col-md-6 col-lg-4">
    <div class="footer-widget-contact">
        <h6 class="footer-widget__title color-heading">Quick Contacts</h6>
        <ul class="contact-list list-unstyled">
            <li>        
                {!! __('main.dental') !!}
            </li>
            <li>
                @foreach(config('site.contacts.phone') as $key => $value)
                    <a href="tel:{{ str_replace(' ', '', str_replace('-', '', str_replace('(' , '', str_replace(')', '', $value)))) }}" class="phone__number" >
                        <i class="icon-phone"></i>
                        <span style="word-break: break-word;">{{ $value }}</span>
                    </a>
                @endforeach
                
                @foreach(config('site.contacts.email') as $key => $value)
                    <a href="mailto:{{ $value }}" class="phone__number" >
                        <i class="icon-email"></i>
                        <span style="word-break: break-word;">{{ $value }}</span>
                    </a>
                @endforeach
            </li>
            @if(config('site.contacts.address.' . $locale))
                <li class="color-body">{{ config('site.contacts.address.' . $locale) }}</li>
            @endif
        </ul>
        <div class="d-flex align-items-center">
            <a href="contact-us.html" class="btn btn__primary btn__link mr-30"><i class="icon-arrow-right"></i><span>Get Directions</span></a>
            @include('includes.socials')
        </div>
    </div>
    <!-- /.footer-widget__content -->
</div>
<!-- /.col-lg-2 -->



