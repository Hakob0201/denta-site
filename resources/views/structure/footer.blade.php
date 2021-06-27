
<!-- ======================== Footer ========================== -->
<footer class="footer">
    <div class="footer-primary">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-3">
                    @include('includes.logo')
                </div>
                <!-- /.col-xl-2 -->
                <div class="col-sm-6 col-md-6 col-lg-2 offset-lg-1">
                    <div class="footer-widget-nav">
                        <h6 class="footer-widget__title">Departments</h6>
                        <nav>
                            <ul class="list-unstyled">
                                <li><a href="#">Neurology Clinic</a></li>
                                <li><a href="#">Cardiology Clinic</a></li>
                                <li><a href="#">Pathology Clinic</a></li>
                                <li><a href="#">Laboratory Analysis</a></li>
                                <li><a href="#">Pediatric Clinic</a></li>
                                <li><a href="#">Cardiac Clinic</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- /.footer-widget__content -->
                </div>
                <!-- /.col-lg-2 -->
                <div class="col-sm-6 col-md-6 col-lg-2">
                    <div class="footer-widget-nav">
                        <h6 class="footer-widget__title">Links</h6>
                        <nav>
                            <ul class="list-unstyled">
                                <li><a href="/{{ $locale }}/about">{{ __('main.about.title') }}</a></li>
                                <li><a href="#">Our CLinic</a></li>
                                <li><a href="#">Our Doctors</a></li>
                                <li><a href="#">News & Media</a></li>
                                <li><a href="#">Appointments</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- /.footer-widget__content -->
                </div>
                <!-- /.col-lg-2 -->
                
                @include('includes.contacts')
                
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.footer-primary -->
    <div class="footer-secondary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-6 col-lg-6"><span class="fz-14">&copy;{{ date('Y') }} RandPages, All Rights Reserved.</div>
                <!-- /.col-lg-6 -->
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <nav>
                        <ul class="list-unstyled footer__copyright-links d-flex flex-wrap justify-content-end mb-0">
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Cookies</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.footer-secondary -->
</footer>
<!-- /.Footer -->
