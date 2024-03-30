// Create cross browser requestAnimationFrame method:
window.requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame || function (f) {
    setTimeout(f, 1000 / 60)
};

//Page functions
var root = {
    _width: 0,
    _height: 0,
    _header_height: 0,
    setup: function (init) {
        this._width = $(window).width();
        this._height = $(window).height();

        if (init === 1) {
            //Code that should be executed only once goes here
            //Add target blank for external links
            $("a[href^=http]").each(function () {
                if (this.href.indexOf(location.hostname) === -1)
                    $(this).attr('target', "_blank");
            });
            root.letter();
        }
        //Code that should execute on window resize goes here
    },
    scrollEvent: function (init) {
        requestAnimationFrame(function () {
            //Add layer behind sticky menu
            var st = $(window).scrollTop();
            if (st >= 200) {
                $('html').addClass('has-scrolled');
            } else {
                $('html').removeClass('has-scrolled');
            }
        });
    },
    get_event: function (cat_id) {
        $('.blocks').addClass('loading');
        $.ajax({
            url: _ajax_url,
            data: { action: 'get_event_ajax', cat_id: cat_id, search_text: search_text, limit: limit, year: year, country: country },
            type: "post",
            success: function (data) {
                $('.blocks').removeClass('loading');
                $('.no_post').remove();
                var data = data.substr(data.length - 1, 1) === '0' ? data.substr(0, data.length - 1) : data;
            }
        });
    },
    letter: function () {
        if ($('.letter').length) {
            var mySwiper = new Swiper('.letter .swiper-container', {
                loop: true,
                slidesPerView: 3,
                spaceBetween: 16,
                autoplay:
                {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".letter .swiper-button-next",
                    prevEl: ".letter .swiper-button-prev",
                },
                breakpoints: {
                    741: {
                        slidesPerView: 2
                    },
                    1025: {
                        slidesPerView: 3
                    }
                }
            });
        }
    },
};