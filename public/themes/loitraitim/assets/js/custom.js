function showButtonScrollTop() {    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {        $('#btn_scroll_to_top').show();    } else {        $('#btn_scroll_to_top').hide();    }}function scrollToTop() {    document.body.scrollTop = 0; /* For Safari */    document.documentElement.scrollTop = 0; /* For Chrome, Firefox, IE and Opera */}$(function () {    $(window).trigger('scroll');    $(window).bind('scroll', function () {        if ($(window).scrollTop() > 50) {            $('body').addClass('header-body-padding-fixed');            $('#header').addClass('fixed');        } else {            $('body').removeClass('header-body-padding-fixed');            $('#header').removeClass('fixed');        }        showButtonScrollTop()    });});