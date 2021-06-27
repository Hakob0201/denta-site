<!-- ============================ Slider ============================== -->
<section class="slider">
    <div class="slick-carousel m-slides-0" data-slick='{"slidesToShow": 1, "arrows": true, "dots": false, "speed": 700,"fade": true,"cssEase": "linear"}'>
        @foreach($headlines->get($cats[0])->slice(0, 3) as $item)
            <div class="slide-item align-v-h">
                <div class="bg-img">
                    @include('includes.articles.image', ['type' => 'w-', 'class' => ''])
                    @if($layouts['article'][$item->layout_id] != 'article')
                        <img class="w-auto absolute top-0 m-12 z-10" src="/assets/svg/{{ $layouts['article'][$item->layout_id] }}-white.svg" alt="{{ $layouts['article'][$item->layout_id] }}">
                    @endif
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-7">
                            <div class="slide__content">
                                <a href="/{{ $locale }}/article/{{ $item->article_id }}">
                                    <h2 class="slide__title">{{ $item->title }}</h2>
                                </a>
                                <p class="slide__desc">{{ $item->datetime_at }}</p>
                                {{-- <p class="slide__desc">The health and well-being of our patients and their health care team will always be our priority,so we follow the best practices for cleanliness.</p>
                                <ul class="features-list list-unstyled mb-0 d-flex flex-wrap">
                                    <!-- feature item #1 -->
                                    <li class="feature-item">
                                        <div class="feature__icon"><i class="icon-heart"></i></div>
                                        <h2 class="feature__title">Examination</h2>
                                    </li>
                                    <!-- /.feature-item-->
                                    <!-- feature item #2 -->
                                    <li class="feature-item">
                                        <div class="feature__icon"><i class="icon-medicine"></i></div>
                                        <h2 class="feature__title">Prescription</h2>
                                    </li>
                                    <!-- /.feature-item-->
                                    <!-- feature item #3 -->
                                    <li class="feature-item">
                                        <div class="feature__icon"><i class="icon-heart2"></i></div>
                                        <h2 class="feature__title">Cardiogram</h2>
                                    </li>
                                    <!-- /.feature-item-->
                                    <!-- feature item #4 -->
                                    <li class="feature-item">
                                        <div class="feature__icon"><i class="icon-blood-test"></i></div>
                                        <h2 class="feature__title">Blood Pressure</h2>
                                    </li>
                                    <!-- /.feature-item-->
                                </ul>
                                <!-- /.features-list --> --}}
                            </div>
                            <!-- /.slide-content -->
                        </div>
                        <!-- /.col-xl-7 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container -->
            </div>
            <!-- /.slide-item -->
        @endforeach
    </div>
    <!-- /.carousel -->
</section>
<!-- /.slider -->