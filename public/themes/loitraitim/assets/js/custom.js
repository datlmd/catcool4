

$(function () {
    //hien thi menu scroll
    var last_scroll = 0;

    $(window).trigger('scroll');
    $(window).bind('scroll', function () {
        if ($(window).scrollTop() <= 50 || last_scroll <= $(window).scrollTop()) {
            //down
            last_scroll = $(window).scrollTop();

            $('body').removeClass('header-body-padding-fixed');
            $('#header').removeClass('fixed');

            $('#header .image-change').attr('src', $('#header .image-change').data('change-src-root'));

            
        } else {
            //up
            last_scroll = $(window).scrollTop();

            $('body').addClass('header-body-padding-fixed');
            $('#header').addClass('fixed');
            $('#header .image-change').attr('src', $('#header .image-change').data('change-src'));
            
        }
    });
});
