<!-- ========================= Header =========================== -->
<header class="header header-layout1">
    <div class="header-topbar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <ul class="contact__list d-flex flex-wrap align-items-center list-unstyled mb-0">
                            <li>
                                <button class="miniPopup-emergency-trigger" type="button">24/7 Emergency</button>
                                <div id="miniPopup-emergency" class="miniPopup miniPopup-emergency text-center">
                                    <div class="emergency__icon"><i class="icon-call3"></i></div>
                                    @foreach(config('site.contacts.phone') as $key => $value)
                                        <a href="tel:{{ str_replace(' ', '', str_replace('-', '', str_replace('(' , '', str_replace(')', '', $value)))) }}" class="phone__number"><i class="icon-phone"></i>
                                            <span>{{ $value }}</span>
                                        </a>
                                    @endforeach
                                    <p>Please feel free to contact our friendly reception staff with any general or medical enquiry.</p>
                                    <a href="appointment.html" class="btn btn__secondary btn__link btn__block"><span>Make Appointment</span><i class="icon-arrow-right"></i></a>
                                </div>
                                <!-- /.miniPopup-emergency -->
                            </li>
                            @foreach(config('site.contacts.phone') as $key => $value)
                                <li>
                                    <i class="icon-phone"></i>
                                    <a href="tel:{{ str_replace(' ', '', str_replace('-', '', str_replace('(' , '', str_replace(')', '', $value)))) }}">
                                        {{ $value }}
                                    </a>
                                </li>
                            @endforeach
                            @if(config('site.contacts.address.' . $locale))
                                <li><i class="icon-location"></i><a href="#">Location: {{ config('site.contacts.address.' . $locale) }}</a></li>
                            @endif
                            <li><i class="icon-clock"></i><a href="contact-us.html">Mon - Fri:8:00 am - 7:00 pm</a></li>
                        </ul>
                        <!-- /.contact__list -->
                        <div class="d-flex">
                            <ul class="social-icons list-unstyled mb-0 mr-30">
                                <li>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </li>
                            </ul>
                            <!-- /.social-icons -->
                            <form class="header-topbar__search">
                                <input type="text" class="form-control" placeholder="Search..." /><button class="header-topbar__search-btn"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.header-top -->
    <nav class="navbar navbar-expand-lg sticky-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="index-2.html"><img src="{{ asset('assets/images/logo/logo-light.png') }}" class="logo-light" alt="logo" /><img src="{{ asset('assets/images/logo/logo-dark.png') }}" class="logo-dark" alt="logo" /></a>
            <button class="navbar-toggler" type="button">
                    <span class="menu-lines"><span></span></span>
                </button>
            <div class="collapse navbar-collapse" id="mainNavigation">
                <ul class="navbar-nav ml-auto">
                    <li class="nav__item">
                        <a href="/{{ $locale }}/articles" class="nav__item-link">Posts</a>
                    </li>
                    @foreach(($remaining = $categories->where('layout_id', '!=' , $layouts['category']['key']['custom'])->where('visible', 1))->slice(0, 5) as $key => $cat)
                        <li class="nav__item">
                            <a href="/{{ $locale }}/articles/{{ $cat->category_key }}" class="nav__item-link">{{ $cat->category_name }}</a>
                        </li>
                    @endforeach
                </ul>
                <!-- /.navbar-nav -->
                <button class="close-mobile-menu d-block d-lg-none"><i class="fas fa-times"></i></button>
            </div>
            <!-- /.navbar-collapse -->
            <div class="d-none d-xl-flex align-items-center position-relative ml-30">
                {{-- <div class="miniPopup-departments-trigger">
                    <span class="menu-lines" id="miniPopup-departments-trigger-icon"><span></span></span><a href="departments.html">Departments</a>
                </div>
                <ul id="miniPopup-departments" class="miniPopup miniPopup-departments dropdown-menu">
                    <li class="nav__item"><a href="department-single.html" class="nav__item-link">Neurology Clinic</a></li>
                    <!-- /.nav-item -->
                    <li class="nav__item"><a href="department-single.html" class="nav__item-link">Cardiology Clinic</a></li>
                    <!-- /.nav-item -->
                    <li class="nav__item"><a href="department-single.html" class="nav__item-link">Pathology Clinic</a></li>
                    <!-- /.nav-item -->
                    <li class="nav__item"><a href="department-single.html" class="nav__item-link">Laboratory Clinic</a></li>
                    <!-- /.nav-item -->
                    <li class="nav__item"><a href="department-single.html" class="nav__item-link">Pediatric Clinic</a></li>
                    <!-- /.nav-item -->
                    <li class="nav__item"><a href="department-single.html" class="nav__item-link">Cardiac Clinic</a></li>
                    <!-- /.nav-item -->
                </ul> --}}
                <!-- /.miniPopup-departments -->
                <a href="appointment.html" class="btn btn__primary btn__rounded ml-30"><i class="icon-calendar"></i><span>Appointment</span></a>
            </div>
        </div>
        <!-- /.container -->
    </nav>
    <!-- /.navabr -->
</header>
<!-- /.Header -->