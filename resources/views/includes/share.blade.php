<div class="socials flex print:hidden">
    <a class="hover-orange rounded flex justify-center mr-12 lg:mb-12 items-center border border-primary-20 hover:border-orange hover:border-opacity-100"
       href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
        @if(isset($amp))
            <amp-img class="img-20" src="/assets/svg/facebook-20.svg" alt="facebook"
                     width="9"
                     height="18">
            </amp-img>
        @else
            <img class="img-20" src="/assets/svg/facebook-20.svg" alt="facebook">
        @endif
    </a>
    <a class="hover-orange rounded flex justify-center mr-12 lg:mb-12 items-center border border-primary-20 hover:border-orange hover:border-opacity-100"
       href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank">
        @if(isset($amp))
            <amp-img class="img-20" src="/assets/svg/twitter-20.svg" alt="twitter"
                     width="18"
                     height="14">
            </amp-img>
        @else
            <img class="img-20" src="/assets/svg/twitter-20.svg" alt="twitter">
        @endif
    </a>
</div>
