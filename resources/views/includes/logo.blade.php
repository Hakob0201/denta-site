<div class="footer-widget-about">
    @if(isset($amp))
        <amp-img src="{{ asset('assets/images/logo/logo-light.png') }}" alt="Logo"
                 width="68"
                 height="45">
        </amp-img>
    @else
        <img src="{{ asset('assets/images/logo/logo-light.png') }}" alt="logo" class="mb-30">
    @endif
    <p class="color-gray">
        Our goal is to deliver quality of care in a courteous,respectful,and compassionate manner. We hope you will allow us to care for you and strive to be the first and best choice for your family healthcare.
    </p>
    <a href="appointment.html" class="btn btn__primary btn__primary-style2 btn__link"><span>Make Appointment</span><i class="icon-arrow-right"></i></a>
</div>

