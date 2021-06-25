@extends('layouts.' . ($amp ? 'amp' : 'app'))

@section('content')
    <article class="sm:px-16 pb-45">
        <div class="container">
            @if($audio = App\Audio::find($article->contents->audio_id))
                <div class="podcast flex justify-between relative shadow mb-45 pb-16 lg:pb-0 lg:mb-0">
                    <div
                        class="wave-top bg-white relative flex-1 z-10 p-16 bg-opacity-0 lg:bg-opacity-100 flex flex-col justify-end lg:justify-start">
                        <h1 class="hidden lg:block text-24 text-white lg:text-primary-100 font-semibold mb-16">{{ $article->contents->title }}</h1>
                        @if(isset($amp))
                            @include('includes.articles.image', ['item' => $article, 'class' => 'article-image w-full h-full', 'type' => 'l-'])
                        @endif
                        <div class="flex items-center text-15 text-primary-20 lg:text-primary-50 mb-45 lg:mb-22"
                             style="margin-top:{!! isset($amp) ? '25px' : '' !!}">
                            @if(isset($amp))
                                <amp-img
                                    class="mr-12" src="/assets/svg/time-20.svg" alt="Time"
                                    width="18"
                                    height="18"
                                >
                                </amp-img>
                            @else
                                <img class="mr-12" src="/assets/svg/time-20.svg" alt="Time">
                            @endif
                            {!! round($audio->duration / 60) !!} mins
                        </div>
                        @if(!isset($amp))
                            <span
                                class="play-pause circle absolute lg:static flex justify-center items-center bg-orange bg-opacity-60 rounded-full cursor-pointer">
                            <img class="play" src="/assets/svg/play-white.svg" alt="Play">
                            <img class="pause" src="/assets/svg/pause-white.svg" alt="Pause">
                        </span>
                        @endif
                        <div class="absolute left-0 right-0 bottom-0 lg:my-12 lg:mx-22 lg:overflow-hidden">
                            <div id="waveform" class="cursor-pointer"></div>
                        </div>
                    </div>
                    <div class="image absolute h-full lg:h-auto lg:relative flex-1"
                         style="display: {!! isset($amp) ? 'none' : '' !!}">
                        <div class="absolute top-0 bottom-0 left-0 right-0 bg-black bg-opacity-30"></div>
                        @include('includes.articles.image', ['item' => $article, 'class' => 'article-image w-full h-full', 'type' => 'l-'])
                    </div>
                </div>

                @if(isset($amp))
                    <amp-audio width="auto" height="100px" src="/storage{{$audio->url . $audio->name}}"></amp-audio>
                @else
                    <div
                        class="podcast-control hidden lg:flex pl-16 items-center border-b border-primary-20 bg-light bg-opacity-50 overflow-hidden">
                <span class="cursor-pointer skip-back">
                    <img src="/assets/svg/skip-back-50.svg" alt="Skip Back">
                </span>
                        <span class="cursor-pointer play-pause mx-12">
                    <img class="play" src="/assets/svg/play-50.svg" alt="Play">
                    <img class="pause" src="/assets/svg/pause-50.svg" alt="Pause">
                </span>
                        <span class="cursor-pointer skip-forward">
                    <img src="/assets/svg/skip-forward-50.svg" alt="Skip Forward">
                </span>
                        <div class="flex items-center ml-26">
                            <svg width="25" height="21" viewBox="0 0 25 21" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.0625 20.6562C13.9032 20.6559 13.7478 20.6068 13.6172 20.5156L5.80469 15.0469C5.7012 14.9751 5.6166 14.8793 5.55811 14.7678C5.49961 14.6562 5.46896 14.5322 5.46875 14.4062V6.59375C5.46896 6.4678 5.49961 6.34376 5.55811 6.23221C5.6166 6.12067 5.7012 6.02492 5.80469 5.95312L13.6172 0.484373C13.7311 0.407308 13.8633 0.361668 14.0005 0.352066C14.1376 0.342464 14.2749 0.369239 14.3984 0.429686C14.5302 0.492425 14.6418 0.590815 14.7205 0.713706C14.7992 0.836597 14.8419 0.979076 14.8438 1.125V19.875C14.844 20.0185 14.8048 20.1592 14.7304 20.2819C14.656 20.4045 14.5493 20.5043 14.4219 20.5703C14.3107 20.6273 14.1874 20.6568 14.0625 20.6562ZM7.03125 14L13.2813 18.375V2.625L7.03125 7V14Z"
                                    fill="#767CA3"/>
                                <path
                                    d="M6.25 15.1875H3.125C2.5034 15.1875 1.90726 14.9406 1.46772 14.501C1.02818 14.0615 0.78125 13.4654 0.78125 12.8438V8.15625C0.78125 7.53465 1.02818 6.93851 1.46772 6.49897C1.90726 6.05943 2.5034 5.8125 3.125 5.8125H6.25C6.4572 5.8125 6.65591 5.89481 6.80243 6.04132C6.94894 6.18784 7.03125 6.38655 7.03125 6.59375V14.4062C7.03125 14.6135 6.94894 14.8122 6.80243 14.9587C6.65591 15.1052 6.4572 15.1875 6.25 15.1875ZM3.125 7.375C2.9178 7.375 2.71909 7.45731 2.57257 7.60382C2.42606 7.75034 2.34375 7.94905 2.34375 8.15625V12.8438C2.34375 13.051 2.42606 13.2497 2.57257 13.3962C2.71909 13.5427 2.9178 13.625 3.125 13.625H5.46875V7.375H3.125Z"
                                    fill="#767CA3"/>
                                <path class="volRemoveLow"
                                      d="M14.0625 14.4062V12.8438C14.5258 12.8433 14.9785 12.7057 15.3635 12.4481C15.7486 12.1905 16.0487 11.8246 16.2259 11.3966C16.4031 10.9686 16.4495 10.4977 16.3593 10.0433C16.269 9.58895 16.0461 9.17152 15.7188 8.84375L16.8281 7.73438C17.3758 8.2807 17.749 8.97735 17.9003 9.73601C18.0516 10.4947 17.9742 11.2812 17.678 11.9958C17.3818 12.7104 16.88 13.321 16.2364 13.7502C15.5927 14.1793 14.8361 14.4076 14.0625 14.4062Z"
                                      fill="#767CA3"/>
                                <path class="volRemoveHigh"
                                      d="M20.6871 17.9063C20.5843 17.9069 20.4824 17.8871 20.3872 17.8483C20.292 17.8094 20.2055 17.7521 20.1325 17.6797C20.0592 17.6071 20.0011 17.5207 19.9615 17.4255C19.9218 17.3303 19.9014 17.2281 19.9014 17.125C19.9014 17.0219 19.9218 16.9198 19.9615 16.8246C20.0011 16.7294 20.0592 16.6429 20.1325 16.5703C21.7402 14.9592 22.6431 12.7761 22.6431 10.5C22.6431 8.22393 21.7402 6.04081 20.1325 4.42969C20.0596 4.35685 20.0018 4.27038 19.9624 4.1752C19.923 4.08003 19.9027 3.97802 19.9027 3.87501C19.9027 3.77199 19.923 3.66999 19.9624 3.57481C20.0018 3.47964 20.0596 3.39316 20.1325 3.32032C20.2053 3.24748 20.2918 3.1897 20.387 3.15027C20.4821 3.11085 20.5841 3.09056 20.6871 3.09056C20.7902 3.09056 20.8922 3.11085 20.9873 3.15027C21.0825 3.1897 21.169 3.24748 21.2418 3.32032C23.1454 5.22483 24.2147 7.80732 24.2147 10.5C24.2147 13.1927 23.1454 15.7752 21.2418 17.6797C21.1688 17.7521 21.0823 17.8094 20.9871 17.8483C20.8919 17.8871 20.79 17.9069 20.6871 17.9063Z"
                                      fill="#767CA3"/>
                                <path class="volRemoveMed"
                                      d="M18.4767 15.6953C18.2718 15.6944 18.0754 15.6131 17.9299 15.4687C17.8011 15.3194 17.7335 15.1269 17.7408 14.9298C17.748 14.7328 17.8295 14.5457 17.9689 14.4062C18.4768 13.8984 18.8797 13.2955 19.1545 12.632C19.4294 11.9684 19.5709 11.2573 19.5709 10.5391C19.5709 9.82084 19.4294 9.10966 19.1545 8.44612C18.8797 7.78259 18.4768 7.17969 17.9689 6.67187C17.8409 6.52241 17.774 6.33016 17.7816 6.13354C17.7892 5.93692 17.8707 5.75041 18.0099 5.61127C18.149 5.47213 18.3355 5.39062 18.5322 5.38303C18.7288 5.37543 18.921 5.44231 19.0705 5.5703C20.3872 6.88867 21.1268 8.67577 21.1268 10.5391C21.1268 12.4023 20.3872 14.1894 19.0705 15.5078C18.9896 15.5781 18.8952 15.631 18.7931 15.6633C18.6909 15.6955 18.5833 15.7064 18.4767 15.6953Z"
                                      fill="#767CA3"/>
                            </svg>
                            <input class="input-range" type="range" value="50" min="1" max="100">
                        </div>
                        <div class="waveformSpeed flex ml-45 text-primary-50">
                            <span class="border border-primary-50 rounded cursor-pointer" data-speed="0.5">0.5x</span>
                            <span class="border border-primary-50 rounded cursor-pointer" data-speed="0.75">0.75x</span>
                            <span class="border rounded cursor-pointer bg-orange text-white border-orange current"
                                  data-speed="1">1x normal</span>
                            <span class="border border-primary-50 rounded cursor-pointer" data-speed="1.25">1.25x</span>
                            <span class="border border-primary-50 rounded cursor-pointer" data-speed="1.5">1.5x</span>
                        </div>
                    </div>
                @endif
            @endif
            @include('articles.item.body')
        </div>
    </article>
@stop

@section('schema')
    @include('includes.microdata.item')
@stop
@section('js')

    <script src="https://unpkg.com/wavesurfer.js"></script>
    @if($audio)
        <script>
            var height = 120;
            var config = {
                container: '#waveform',
                backend: 'MediaElement',
                waveColor: '#D3D2DD',
                progressColor: '#DF7C7C',
                height: height,
                barWidth: 1,
                barGap: 5,
                hideScrollbar: true,
                cursorWidth: 0,
                normalize: true,
                partialRender: 'PeakCache',
                responsive: true
            };

            if ($(window).width() < 1025) {
                config.mediaControls = true;
                $('.podcastImage').on('click', function () {
                    $('.waveformControlls').addClass('open');
                });
            } else {
                $('.podcast, .podcast-control').hover(
                    function () {
                        $('.podcast-control').addClass('open');
                    },
                    function () {
                        $('.podcast-control').removeClass('open');
                    }
                );
            }

            var wavesurfer = WaveSurfer.create(config);

            $.get("/storage{{ $audio->url . $audio->name }}.json", function (data) {
            }).done(function (data) {
                wavesurfer.load('/storage{{ $audio->url . $audio->name }}', data);
            });

            wavesurfer.drawer.on('click', function () {
                $('.play-pause').addClass('on');
                wavesurfer.play();
            });

            wavesurfer.on('play', function () {
                $('.volStyle').text('.input-range:after{width:' + wavesurfer.getVolume() * 100 + '% !important;}');
            });

            $('.play-pause').on('click', function () {
                $('.play-pause').toggleClass('on');
                wavesurfer.playPause();
            });

            $('.skip-back').on('click', function () {
                wavesurfer.skipBackward(10);
            });

            $('.skip-forward').on('click', function () {
                wavesurfer.skipForward(10);
            });

            $(document).on('click', ".waveformSpeed > span", function () {
                if (!$(this).hasClass('current')) {
                    $('.waveformSpeed > span').removeClass('current bg-orange text-white border-orange');
                    $(this).addClass('current bg-orange text-white border-orange');
                }
                $('.waveformSpeed').toggleClass('all');
                wavesurfer.setPlaybackRate($(this).attr('data-speed'));
            });

            $('.input-range').on('input', function () {
                $('.volStyle').text('.input-range:after{width:' + $(this).val() + '% !important;}');
                wavesurfer.setVolume(($(this).val() / 100) - 0.01);

                if ($(this).val() < 80) {
                    $('.volRemoveHigh').hide();
                } else if ($('.volRemoveHigh').is(":hidden")) {
                    $('.volRemoveHigh').show();
                }
                if ($(this).val() < 35) {
                    $('.volRemoveMed').hide();
                } else if ($('.volRemoveMed').is(":hidden")) {
                    $('.volRemoveMed').show();
                }
                if ($(this).val() < 10) {
                    $('.volRemoveLow').hide();
                } else if ($('.volRemoveLow').is(":hidden")) {
                    $('.volRemoveLow').show();
                }
            });
            $('head').append('<style class="volStyle"></style>');
        </script>
    @endif
@stop
