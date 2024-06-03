
var is_processing = false;
var Catcool = {
    submitFormAjax: function (e) {


        //return false;
    },
};

function showButtonScrollTop() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        $('#btn_scroll_to_top').show();
    } else {
        $('#btn_scroll_to_top').hide();
    }
}

function scrollToTop() {
    document.body.scrollTop = 0; /* For Safari */
    document.documentElement.scrollTop = 0; /* For Chrome, Firefox, IE and Opera */
}

$(document).on('show.bs.offcanvas, shown.bs.offcanvas','header#header', function () {
    $('html').css({'overflow': 'hidden'});
});

$(document).on('hidden.bs.offcanvas, hide.bs.offcanvas','header#header', function () {
    $('html').css({'overflow': ''});
});

// Forms
$(document).on('submit', 'form', function (e) {
    var element = this;

    if (e.originalEvent !== undefined && e.originalEvent.submitter !== undefined) {
        var button = e.originalEvent.submitter;
    } else {
        var button = '';
    }

    var status = false;

    var ajax = $(element).attr('data-cc-toggle');

    if (ajax == 'ajax') {
        status = true;
    }

    var ajax = $(button).attr('data-cc-toggle');

    if (ajax == 'ajax') {
        status = true;
    }

    if (status) {
        if (is_processing) {
            return false;
        }
        is_processing = true;

        e.preventDefault();

        // Form attributes
        var form = e.target;

        var action = $(form).attr('action');

        var method = $(form).attr('method');

        if (method === undefined) {
            method = 'post';
        }

        var enctype = $(form).attr('enctype');

        if (enctype === undefined) {
            enctype = 'application/x-www-form-urlencoded';
        }

        // Form button overrides
        var formaction = $(button).attr('formaction');

        if (formaction !== undefined) {
            action = formaction;
        }

        var formmethod = $(button).attr('formmethod');

        if (formmethod !== undefined) {
            method = formmethod;
        }

        var formenctype = $(button).attr('formenctype');

        if (formenctype !== undefined) {
            enctype = formenctype;
        }

        if (button) {
            var formaction = $(button).attr('data-type');
        }

        // https://github.com/opencart/opencart/issues/9690
        // if (typeof CKEDITOR != 'undefined') {
        //     for (instance in CKEDITOR.instances) {
        //         CKEDITOR.instances[instance].updateElement();
        //     }
        // }

        console.log(e);
        console.log('element ' + element);
        console.log('action ' + action);
        console.log('button ' + button);
        console.log('formaction ' + formaction);
        console.log('method ' + method);
        console.log('enctype ' + enctype);
        console.log($(element).serialize());

        $('body').append('<div class="loading"><div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status"></div></div>');

        $.ajax({
            url: action,
            type: method,
            data: $(form).serialize(),
            dataType: 'json',
            cache: false,
            contentType: enctype,
            processData: false,
            beforeSend: function () {
                //$(button).prop('disabled', true).addClass('loading');
                $(button).find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
            },
            complete: function () {
                $(button).find('i').replaceWith('<i></i>');
                //$(button).prop('disabled', false).removeClass('loading');
            },
            success: function (json) {
                $('.loading').remove().fadeOut();
                is_processing = false;

                $('.alert-dismissible').remove();
                $(form).find('.is-invalid').removeClass('is-invalid');
                $(form).find('.invalid-feedback').removeClass('d-block');

                if (json['token']) {
                    // Update CSRF hash
                    $("input[name*='" + csrf_token + "']").val(json['token']);
                }

                if (json['redirect']) {
                    location = json['redirect'].replaceAll('&amp;', '&');
                }

                if (typeof json['error'] == 'string') {
                    $.notify(json['error'], {'type': 'danger'});
                    // $('#alert').prepend('<div class="alert alert-danger alert-dismissible"><i class="fa-solid fa-circle-exclamation"></i> ' + json['error'] + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                }

                if (typeof json['error'] == 'object') {
                    // if (json['error']['warning']) {
                    //     $.notify(json['error']['warning'], {'type': 'danger'});
                    // }

                    for (key in json['error']) {
                        $('#input_' + key.replaceAll('.', '_')).addClass('is-invalid').find('.form-control, .form-select, .form-check-input, .form-check-label').addClass('is-invalid');
                        $('#error_' + key.replaceAll('.', '_')).html(json['error'][key]).addClass('d-block');

                        //$.notify(json['error'][key], {'type': 'danger'});
                    }
                }

                if (json['alert']) {
                    if ($(form).data('alert') != "") {
                        $($(form).data('alert')).prepend(json['alert']);
                    } else {
                        $('#alert').prepend(json['alert']);
                    }
                }

                if (json['success']) {
                    //$.notify(json['success']);

                    // Refresh
                    var url = $(form).attr('data-cc-load');
                    var target = $(form).attr('data-cc-target');

                    if (url !== undefined && target !== undefined) {
                        $(target).load(url);
                    }
                }

                // Replace any form values that correspond to form names.
                for (key in json) {
                    $(form).find('[name=\'' + key + '\']').val(json[key]);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loading').remove().fadeOut();
                is_processing = false;
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                // $.notify(xhr.responseJSON.message,
                //     {'type': 'danger'},
                // );
            }
        });

        return false;
    }
});

$(function () {
    //hien thi menu scroll
    var last_scroll = 0;

    var height_header_main_pc = $('#header_main_pc').height();
    if (height_header_main_pc <= 0) {
        height_header_main_pc = $('#header_main_mobile').height();
    }

    $('#header_main_pc .header-bottom-scroll').css('height', $('#header_main_pc .header-bottom').height());
    $('#header_main_mobile .header-mobile-scroll').css('height', $('#header_main_mobile').height());

    $(window).trigger('scroll');
    $(window).bind('scroll', function () {

        if ($(window).scrollTop() <= height_header_main_pc || last_scroll <= $(window).scrollTop()) {
            //down
            last_scroll = $(window).scrollTop();

            //menu pc
            $('#header_main_pc .header-bottom-scroll').hide();
            $('#header_main_pc .header-bottom').removeClass('fixed');

            //menu mobile
            $('#header_main_mobile .header-mobile-scroll').hide();
            $('#header_main_mobile').removeClass('fixed');
        } else {
            //up
            last_scroll = $(window).scrollTop();

            //menu pc
            $('#header_main_pc .header-bottom-scroll').show();
            $('#header_main_pc .header-bottom').addClass('fixed');

            //menu mobile
            $('#header_main_mobile .header-mobile-scroll').show();
            $('#header_main_mobile').addClass('fixed');
        }

        showButtonScrollTop()
    });

    $(document).on('submit', 'form', function (e) {
        Catcool.submitFormAjax(e);
    });

    /* set gia tri mac dinh alert */
    $.notifyDefaults({
        type: 'success',
        placement: {
            from: 'bottom',
            align: 'right'
        },
        template: '<div data-notify="container" class="mx-2 alert alert-{0} alert-dismissible" role="alert"><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
    });
});
