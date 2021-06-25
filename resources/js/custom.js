$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let canSend = true;
let timer = null;

function getCatntag() {
    if (typeof window.localStorage != 'undefined') {
        const now = new Date();

        if (localStorage.getItem('catntag') === null) {
            $.post('/' + $('html').attr('lang') + '/search/catntag', function (data) {
                const item = {
                    data: data,
                    expire: now.getTime() + (1000 * 60 * 60)
                }

                localStorage.setItem('catntag', JSON.stringify(item));
            });
        } else if (now.getTime() > JSON.parse(localStorage.getItem('catntag')).expire) {
            localStorage.removeItem('catntag');

            return getCatntag();
        }
    }
}

$('.search-input').on('keyup', function (e) {
    const searchData = JSON.parse(JSON.parse(localStorage.getItem('catntag')).data);
    let toSearch = $(this).val().toLowerCase();

    $('.search-button').attr('href', '/' + $('html').attr('lang') + '/search?q=' + toSearch);

    if (e.which === 13 && toSearch.length >= 3) {
        $('.search-button')[0].click();

        return;
    }

    if(e.key === "Escape") {
        $('.search').trigger('click');

        return;
    }

    clearTimeout(timer);
    timer = setTimeout(function () {
        if (toSearch.length >= 3) {
            if (canSend === true) {
                canSend = false;
                $.get('/' + $('html').attr('lang') + '/search?q=' + toSearch, function () {

                }).done(function (data) {
                    for (let i = 0; i < data['data'].length; i++) {
                        $('.search-result .articles div').append('<a class="block px-12 py-16 transition duration-300 hover:bg-primary-20 hover:bg-opacity-20" href="/' + $('html').attr('lang') + '/article/' + data['data'][i]['contents']['article_id'] + '"><h4>' + data['data'][i]['contents']['title'] + '</h4><p class="text-14 text-primary-50 mt-12">' + data['data'][i]['contents']['anons'] + '</p></a>');
                    }

                    $('.search-result .articles .flavor').children().addClass('hidden');

                    canSend = true;
                }).fail(function () {
                    $('.search-result .articles .flavor .load').addClass('hidden');
                    $('.search-result .articles .flavor .fail').removeClass('hidden');

                    canSend = true;
                });
            }
        }
        else {
            $('.search-result .articles .flavor .load').addClass('hidden');
            $('.search-result .articles .flavor .fail').removeClass('hidden');
        }
    }, 500);

    $('.search-result').children().addClass('hidden').find('div').text('');
    $('.black-bg').addClass('pointer-events-none').removeClass('opacity-80').addClass('opacity-0');

    if (toSearch !== '') {
        $('.black-bg').removeClass('pointer-events-none').addClass('opacity-80').removeClass('opacity-0');
        $('.search-result .articles').removeClass('hidden');
        $('.search-result .articles .flavor .load').removeClass('hidden');
        $('.search-result .articles .flavor .fail').addClass('hidden');

        for (let type in searchData) {
            for (let i = 0; i < searchData[type].length; i++) {
                for (let key in searchData[type][i]) {
                    if (typeof searchData[type][i][key] === 'string' && searchData[type][i][key].indexOf(toSearch) !== -1) {
                        $('.search-result .' + type).removeClass('hidden');

                        $('.search-result .' + type + ' div').append('<a class="flex px-12 py-16 capitalize transition duration-300 hover:bg-primary-20 hover:bg-opacity-20" href="/' + $('html').attr('lang') + '/' + ((type === 'categories') ? 'articles' : 'tag') + '/' + searchData[type][i][(type === 'categories') ? 'category_key' : 'tag_slug'] + '">' + searchData[type][i][(type === 'categories') ? 'category_name' : 'tag_name'] + '</a>');
                        break;
                    }
                }
            }
        }
    }
});

$('.black-bg').on('click', function () {
    $('.search').trigger('click');
});

$('.search').on('click', function () {
    let overflow = true;

    if ($(window).width() > 1023) {
        overflow = false;
    }

    if ($('.search-body').hasClass('open-top')) {
        $('.search-result').children().addClass('hidden');
        $('.search-input').blur();
    }
    else {
        $('.search-input').focus();
    }

    mobileOpen('.search-body', $('.search'), 'search-20', overflow);
});

$('.menu').on('click', function () {
    mobileOpen('.menu-body', $('.menu.mobile-move'), 'menu');
});

$('.mobile-feed').on('click', function () {
    if ($('.feed').length > 0) {
        mobileOpen('.feed', $(this), 'feed');
    }
    else if (!$(this).hasClass('disabled')) {
        $(this).addClass('disabled').find('.animate-spin').removeClass('hidden');

        $.get('/' + $('html').attr('lang') + '/feed').done(function (data) {
            $('body').append(data);

            dinScroll($('.feed'));
            relativeDates();

            setTimeout(function(){
                mobileOpen('.feed', $('.mobile-feed'), 'feed');
                $('.mobile-feed').removeClass('disabled').find('.animate-spin').addClass('hidden');
            }, 300);
        }).fail(function () {
            $('.mobile-feed').removeClass('disabled').find('img').removeClass('animate-spin');
        });
    }
});

function mobileOpen (open, block, icon, overflow = true) {
    if (!$(open).hasClass('open-top')) {
        $('.open-top').removeClass('open-top');
        $(open).addClass('open-top');
    }
    else {
        $('.open-top').removeClass('open-top');
    }
    $('.black-bg').addClass('pointer-events-none').removeClass('opacity-80').addClass('opacity-0');

    let img = block.find('img');

    img.attr('src', '/assets/svg/close-20.svg');

    if (img.hasClass('close-me')) {
        img.attr('src', '/assets/svg/' + icon + '.svg').removeClass('close-me');
        img.attr('data-icon', icon);
    }
    else {
        $('.close-me').attr('src', '/assets/svg/' + $('.close-me').attr('data-icon') + '.svg').removeClass('close-me');
        img.addClass('close-me').attr('data-icon', icon);
    }

    if (overflow) {
        if ($('.close-me').length > 0) {
            $(document.body).addClass('overflow-hidden');
        }
        else {
            $(document.body).removeClass('overflow-hidden');
        }
    }
}

$('.open-sesame .door').on('click', function () {
    $(this).parent().toggleClass('open');
});

$('.toggle-black-bg').on({
    mouseenter: function () {
        $('.black-bg').removeClass('pointer-events-none').addClass('opacity-80').removeClass('opacity-0');
    },
    mouseleave: function () {
        $('.black-bg').addClass('pointer-events-none').addClass('opacity-0').removeClass('opacity-80');
    }
});

function relativeDates() {
    var locale = $('html').attr('lang');
    var now = moment();

    $('.relative-date').each(function(i, e){
        if (locale == 'hy')
            locale = 'hy-am';
        moment.locale(locale);
        // moment.locale('hy-am');
        var mDate = moment($(e).attr('datetime')).utcOffset('+0400');
        var diff = now.diff(mDate, 'days');

        if($(e).hasClass('long')) {
            $(e).html(mDate.format('HH:mm, Do MMM YYYY'));
        }
        else if($(e).hasClass('time')) {
            $(e).html(mDate.format('H:mm'));
        }
        else if($(e).hasClass('month')) {
            $(e).html(mDate.format('Do MMM')); // Short month
            // $(e).html(mDate.format('Do MMMM')); // Full month
        }
        else if($(e).hasClass('short')) {
            $(e).html(mDate.format('Do MMM YYYY'));
        }
        else if($(e).hasClass('date')) {
            $(e).html(mDate.format('D MMMM,') + '<span class="lowercase"> ' + mDate.format('dddd') + '</span>');
        }
        else {
            $(e).html(mDate.format('HH:mm') + '<br><span>' + mDate.format('Do MMM YYYY') + '</span>');
        }
    });
}

$('.slider-half').each(function () {
    $(this).owlCarousel({
        lazyLoad: true,
        dots: false,
        navText: ["<svg width=\"13\" height=\"24\" viewBox=\"0 0 13 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M2.47775 12L12.6994 22.2441C13.1002 22.6458 13.1002 23.2971 12.6994 23.6987C12.2986 24.1004 11.6488 24.1004 11.248 23.6987L0.300601 12.7273C-0.1002 12.3256 -0.1002 11.6744 0.300601 11.2727L11.248 0.301262C11.6488 -0.100421 12.2986 -0.100421 12.6994 0.301262C13.1002 0.702944 13.1002 1.3542 12.6994 1.75588L2.47775 12Z\" fill=\"#001845\"/></svg>","<svg width=\"13\" height=\"24\" viewBox=\"0 0 13 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M10.5223 12L0.300602 1.75588C-0.1002 1.3542 -0.1002 0.702941 0.300602 0.301259C0.701402 -0.100423 1.35123 -0.100423 1.75203 0.301259L12.6994 11.2727C13.1002 11.6744 13.1002 12.3256 12.6994 12.7273L1.75203 23.6987C1.35123 24.1004 0.701405 24.1004 0.300604 23.6987C-0.100198 23.2971 -0.100198 22.6458 0.300604 22.2441L10.5223 12Z\" fill=\"#001845\"/></svg>"],
        responsive: {
            0: {
                items: 1,
                margin: 16,
                nav: false,
                stagePadding: 20,
            },
            640: {
                items: 2,
                margin: 16,
                nav: false,
                stagePadding: 0,
            },
            1024: {
                items: 2,
                margin: 30,
                nav: true,
                stagePadding: 0,
            }
        }
    })
});

$('.slider-full').owlCarousel({
    lazyLoad: true,
    dots: false,
    navText: ["<svg width=\"13\" height=\"24\" viewBox=\"0 0 13 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M2.47775 12L12.6994 22.2441C13.1002 22.6458 13.1002 23.2971 12.6994 23.6987C12.2986 24.1004 11.6488 24.1004 11.248 23.6987L0.300601 12.7273C-0.1002 12.3256 -0.1002 11.6744 0.300601 11.2727L11.248 0.301262C11.6488 -0.100421 12.2986 -0.100421 12.6994 0.301262C13.1002 0.702944 13.1002 1.3542 12.6994 1.75588L2.47775 12Z\" fill=\"#001845\"/></svg>","<svg width=\"13\" height=\"24\" viewBox=\"0 0 13 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M10.5223 12L0.300602 1.75588C-0.1002 1.3542 -0.1002 0.702941 0.300602 0.301259C0.701402 -0.100423 1.35123 -0.100423 1.75203 0.301259L12.6994 11.2727C13.1002 11.6744 13.1002 12.3256 12.6994 12.7273L1.75203 23.6987C1.35123 24.1004 0.701405 24.1004 0.300604 23.6987C-0.100198 23.2971 -0.100198 22.6458 0.300604 22.2441L10.5223 12Z\" fill=\"#001845\"/></svg>"],
    responsive: {
        0: {
            items: 1,
            margin: 16,
            nav: false,
            stagePadding: 20,
        },
        640: {
            items: 2,
            margin: 16,
            nav: false,
            stagePadding: 0,
        },
        1024: {
            items: 4,
            margin: 30,
            nav: true,
            stagePadding: 0,
        }
    }
});

$('.article-slider').owlCarousel({
    lazyLoad: true,
    items: 1,
    nav: true,
    dots: false,
    autoHeight: true,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    navText: ["<svg width=\"13\" height=\"24\" viewBox=\"0 0 13 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M2.47775 12L12.6994 22.2441C13.1002 22.6458 13.1002 23.2971 12.6994 23.6987C12.2986 24.1004 11.6488 24.1004 11.248 23.6987L0.300601 12.7273C-0.1002 12.3256 -0.1002 11.6744 0.300601 11.2727L11.248 0.301262C11.6488 -0.100421 12.2986 -0.100421 12.6994 0.301262C13.1002 0.702944 13.1002 1.3542 12.6994 1.75588L2.47775 12Z\" fill=\"#FFFFFF\"/></svg>","<svg width=\"13\" height=\"24\" viewBox=\"0 0 13 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M10.5223 12L0.300602 1.75588C-0.1002 1.3542 -0.1002 0.702941 0.300602 0.301259C0.701402 -0.100423 1.35123 -0.100423 1.75203 0.301259L12.6994 11.2727C13.1002 11.6744 13.1002 12.3256 12.6994 12.7273L1.75203 23.6987C1.35123 24.1004 0.701405 24.1004 0.300604 23.6987C-0.100198 23.2971 -0.100198 22.6458 0.300604 22.2441L10.5223 12Z\" fill=\"#FFFFFF\"/></svg>"],
});

$('.datepicker-i').datepicker({
    autoClose: true,
    timepicker: false,
    offset: 10,
    todayButton: new Date(),
    onSelect: function (fd, d, picker) {
        let cat  = picker.$el.data('category') + '/';
        if (cat === 'all-articles/') {
            cat = '';
        }

        window.location.href = '/' + $('html').attr('lang') + '/' + picker.$el.data('type') + '/' + cat + fd;
    },
    onShow: function (picker, animationCompleted) {
        picker.$el.parent().find('img').attr('src', '/assets/svg/close-red.svg');
        if (animationCompleted) {
            picker.$el.addClass('pointer-events-none');
        }
    },
    onHide: function (picker) {
        picker.$el.removeClass('pointer-events-none');
        picker.$el.parent().find('img').attr('src', '/assets/svg/calendar.svg');
    }
});

$('.magnific-popup').magnificPopup({
    delegate: 'a', // the selector for gallery item
    type: 'image',
    gallery: {
        enabled:true
    }
});

let scrollX = 2;
let pag, less, more;

if ($(window).width() > 1023) {
    scrollX = 0;
}

$('.inf-scroll').scroll(function () {
    infScroll($(this));
});

$('body').on('click', '.inf-scroll .load-more .button', function () {
    if (!$(this).hasClass('disabled')) {
        infLoad($(this).parents('.inf-scroll'));
    }
});

function dinScroll (el) {
    el.on("scroll", function(){
        infScroll($(this));
    });
}

function infLoad (pag) {
    let loc = '';
    let button = pag.find('.load-more');

    button.children().not('.button').removeClass('hidden opacity-0');

    if (pag.attr('data-inline') === 'true') {
        loc = window.location.origin + '/' + $('html').attr('lang') + '/feed?page=' + pag.attr('data-page');
    }
    else {
        loc = window.location.href.split('?')[0] + '?page=' + pag.attr('data-page');
    }

    button.find('.load').children().toggleClass('hidden');

    $.get(loc).done(function (data) {
        scrollX ++;

        if (pag.attr('data-inline') !== 'true') {
            history.pushState(history.state, history.pageTitle, window.location.href.split('?')[0] + '?page=' + pag.attr('data-page'));
        }

        button.removeClass('disable');

        if (pag.attr('data-page').includes('q')) {
            let after = pag.attr('data-page').split('=')[1];
            pag.attr('data-page', (parseInt(pag.attr('data-page').split('&')[0]) + 1) + '&q=' + after);
        }
        else {
            pag.attr('data-page', parseInt(pag.attr('data-page')) + 1);
        }

        $(data).insertBefore(button.parent());

        relativeDates();
    }).always(function () {
        button.removeClass('loading');
        button.find('.load').children().toggleClass('hidden');
    }).fail(function () {
        button.find('.icon').attr('src', '/assets/svg/close-20.svg').removeClass('animate-spin');
        button.find('.text').children().toggleClass('hidden');
        button.find('.button').addClass('disabled').children().toggleClass('hidden');
    });
}

function infScroll (pag) {
    let button = pag.find('.load-more');

    if (pag.css('overflow-y') === 'scroll' || pag.css('overflow-y') === 'auto') {
        less = button.position().top;
        more = pag.height();
    }
    else {
        less = button[0].getBoundingClientRect().top;
        more = $(window).height();
    }

    if (less < more && scrollX < 2) {
        if (!button.hasClass('disable')) {
            infLoad(pag);
        }

        button.addClass('loading disable');
    }
    else if (scrollX >= 2) {
        button.find('.text').remove();
        button.find('.icon').addClass('opacity-0');
        button.find('.button').removeClass('hidden');
    }
}

let lst = 0;

$(window).scroll(function () {
    if ($('.inf-scroll').length > 0) {
        if ($('.inf-scroll').find('.load-more').length > 0 && $('.inf-scroll').find('.load-more').attr('data-inline') !== 'true') {
            infScroll($('.inf-scroll'));
        }
    }

    if ($(window).width() < 1024) {
        let st = $(this).scrollTop();
        if (st - lst > 0) {
            lst = st;
        }
        if (st - lst < -800) {
            lst = st + 800;
        }

        if (lst - st < 400 && $(this).scrollTop() !== 0){
            $('.mobile-move').addClass('hide');
        } else {
            $('.mobile-move').removeClass('hide');
        }
    }
});

getCatntag();
relativeDates();
