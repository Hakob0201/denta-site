(function( $ ) {
    let scrollX = 0;
    let pag, less, more;

    $.fn.scroller = function () {
        let master = this;

        if ($(window).width() < 1024) {
            scrollX = 2;
        }

        if (master.find('.load-more').attr('data-inline') !== 'true') {
            $(window).scroll(function () {
                infScroll(master.find('.load-more'));
            });
        }

        master.scroll(function () {
            infScroll($(this).find('.load-more'));
        });
    };

    $.fn.dinScroll = function () {
        this.on("scroll", function(){
            infScroll($(this).find('.load-more'));
        });
    }

    $('body').on('click', '.inf-scroll .load-more .button', function () {
        if (!$(this).hasClass('disabled')) {
            $(this).text('Loading more...').addClass('animate-pulse');
            infLoad($(this).parent());
        }
    });

    function infScroll (pag) {
        if (pag.parent().css('overflow-y') === 'scroll' || pag.parent().css('overflow-y') === 'auto') {
            less = pag.position().top;
            more = pag.parent().height();
        }
        else {
            less = pag[0].getBoundingClientRect().top;
            more = $(window).height();
        }

        if (less < more && scrollX < 2) {
            if (!pag.hasClass('disable')) {
                infLoad(pag);
            }

            pag.addClass('loading disable');
        }
        else if (scrollX >= 2) {
            pag.find('.text').remove();
            pag.find('.button').removeClass('hidden');
        }
    }

    function infLoad (pag) {
        let loc = '';

        pag.children().not('.button').removeClass('hidden');

        if (pag.attr('data-inline') === 'true') {
            loc = window.location.origin + '/' + $('html').attr('lang') + '/feed?page=' + pag.attr('data-page');
        }
        else {
            loc = window.location.href.split('?')[0] + '?page=' + pag.attr('data-page');
        }

        $.get(loc, function (data) {

        }).done(function (data) {
            scrollX ++;

            if (pag.attr('data-inline') !== 'true') {
                history.pushState(history.state, history.pageTitle, window.location.href.split('?')[0] + '?page=' + pag.attr('data-page'));
            }

            pag.removeClass('disable');
            pag.attr('data-page', parseInt(pag.attr('data-page')) + 1);
            pag.children().addClass('hidden');

            $(data).insertBefore(pag);

            // relativeDates();
        }).always(function () {
            pag.removeClass('loading');
            pag.find('.button').text('Load More').removeClass('animate-pulse');
        }).fail(function () {
            pag.find('.icon').attr('src', '/assets/svg/close-20.svg').removeClass('animate-spin');
            pag.find('.text').text('No more articles').removeClass('animate-pulse');
            pag.find('.button').text('No more articles').addClass('disabled');
        });
    }
}( jQuery ));
