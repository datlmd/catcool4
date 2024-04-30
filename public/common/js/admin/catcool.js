var is_processing = false;
var Catcool = {
    makeSlug: function(obj) {
        var text_slug = $(obj).val();
        text_slug = Catcool.convertSlug(text_slug);

        if ($('#' + $(obj).data("slug-id")).length) {
            $('#' + $(obj).data("slug-id")).attr('placeholder', text_slug);
            $('#' + $(obj).data("slug-id")).val(text_slug);
        }

        if ($('#' + $(obj).data("preview-slug")).length && !$('#' + $(obj).data("slug-id")).val().length) {
            $('#' + $(obj).data("preview-slug")).html(text_slug);
        }

        if ($('#' + $(obj).data("title-id")).length) {
            $('#' + $(obj).data("title-id")).attr('placeholder', $(obj).val());
            $('#' + $(obj).data("title-id")).val($(obj).val());
            $('.preview-meta-seo').show();
        }

        if ($('#' + $(obj).data("preview-title")).length && !$('#' + $(obj).data("preview-title")).val().length) {
            $('#' + $(obj).data("preview-title")).html($(obj).val());
        }

        return true;
    },
    convertSlug: function(slug) {
        var text_slug = slug;
        text_slug = text_slug.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();

        //Đổi ký tự có dấu thành không dấu
        text_slug = text_slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        text_slug = text_slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        text_slug = text_slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        text_slug = text_slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        text_slug = text_slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        text_slug = text_slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        text_slug = text_slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        text_slug = text_slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        text_slug = text_slug.replace(/ /gi, " - ");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        text_slug = text_slug.replace(/\-\-\-\-\-/gi, '-');
        text_slug = text_slug.replace(/\-\-\-\-/gi, '-');
        text_slug = text_slug.replace(/\-\-\-/gi, '-');
        text_slug = text_slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        text_slug = '@' + text_slug + '@';
        text_slug = text_slug.replace(/\@\-|\-\@|\@/gi, '');

        text_slug = text_slug.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

        return text_slug;
    },
    setContentSeo: function(obj) {
        if (!$('#' + $(obj).data("seo-id")).length) {
            return;
        }

        var text_seo = "";
        if ($(obj).val().length) {
            text_seo = $(obj).val();
        }
        // else if ($(obj).attr('placeholder')){
        //     text_seo = $(obj).attr('placeholder');
        // }

        if ($(obj).data("is-slug")) {
            text_seo = Catcool.convertSlug(text_seo);
            $(obj).val(text_seo);
        }

        $('.preview-meta-seo').show();
        $('#' + $(obj).data("seo-id")).html(text_seo);

        var length_id = $(obj).data("seo-id") + '_length';
        if ($('#' + length_id).length) {
            if ($(obj).val().length) {
                $('#' + length_id).html($(obj).val().length);
            } else if ($(obj).attr('placeholder')){
                $('#' + length_id).html($(obj).attr('placeholder').length);
            } else {
                $('#' + length_id).html(0);
            }
        }

        if ($.trim($('.preview-meta-seo .meta-seo-title').html()) == '' && $.trim($('.preview-meta-seo .meta-seo-url').html()) == '' && $.trim($('.preview-meta-seo .meta-seo-description').html()) == '') {
            $('.preview-meta-seo').hide();
        }
    },
    checkLoadContentSeo: function() {
        if (!$('.seo-meta-length').length) {
            return false;
        }

        $('.seo-meta-length').each(function() {
            var length_id = $(this).data('target');
            if ($('#' + length_id).val().length) {
                $(this).html($('#' + length_id).val().length);
            } else if ($('#' + length_id).attr('placeholder')) {
                $(this).html($('#' + length_id).attr('placeholder').length);
            } else {
                $(this).html(0);
            }
        });

        return true;
    },
    changePublish: function (obj) {
        if (is_processing) {
            return false;
        }
        if (!$('input[name="manage_url"]').length) {
            return false;
        }

        var manage   = $('input[name="manage_url"]').val();
        var id       = $(obj).data("id");
        var is_check = 0;
        var url_api  = manage + '/publish';

        if ($(obj).is(':checked')) {
            is_check = 1;
        }

        is_processing = true;
        $.ajax({
            url: url_api,
            data: {
                'id' : id,
                'published': is_check,
                'data': $(obj).data(),
                [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
            },
            type:'POST',
            success: function (data) {
                is_processing = false;

                var response = JSON.stringify(data);
                response = JSON.parse(response);

                if (response.token) {
                    // Update CSRF hash
                    $("input[name*='" + csrf_token + "']").val(response.token);
                }

                if (response.status == 'ng') {
                    $.notify(response.msg, {'type':'danger'});
                    $(obj).prop("checked", $(obj).attr("value"));
                    return false;
                }
                $.notify(response.msg);
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
                $.notify({
                        message: xhr.responseJSON.message + " Please reload the page!!!",
                        url: window.location.href,
                        target: "_self",
                    }, 
                    {'type': 'danger'},
                );
            }
        });
    },
    checkBoxDelete: function () {
        if (!$('input[name="manage_check_all"]').length) {
            return false;
        }
        if (!$('input[name="manage_ids[]"]').length) {
            return false;
        }

        $(document).on('change', 'input[name="manage_check_all"]', function() {
            $('#delete_multiple').addClass(['animate__animated', 'animate__fadeIn']).show();
            $('input[name="manage_ids[]"]').prop('checked', $(this).prop("checked"));
            if (!$('input[name="manage_ids[]"]:checked').length) {
                $('#delete_multiple').hide();
            }
        });
        $(document).on('change', 'input[name="manage_ids[]"]', function() {
            $('input[name="manage_ids[]"]').each(function(){
                if($(this).is(":checked")) {
                    $('#delete_multiple').addClass(['animate__animated', 'animate__fadeIn']).show();
                }
            });

            $('input[name="manage_check_all"]').prop('checked', false);
            if (!$('input[name="manage_ids[]"]:checked').length) {
                $('#delete_multiple').hide();
            } else if ($('input[name="manage_ids[]"]:checked').length == $('input[name="manage_ids[]"]').length) {
                $('input[name="manage_check_all"]').prop('checked', true);
            }
        });
        $(document).on('click', "#delete_multiple", function(e) {
            e.preventDefault();
            var element = $(this);
            var boxes = [];
            $('input[name="manage_ids[]"]:checked').each(function(){
                boxes.push($(this).val());
            });

            Catcool.getModalDelete(element, boxes);

        });
    },
    deleteSingle: function () {
        if (!$('.btn_delete_single').length) {
            return false;
        }

        $(document).on('click', ".btn_delete_single", function(e) {
            e.preventDefault();
            var element = $(this);
            Catcool.getModalDelete(element, element.data('id'), true);
        });
    },
    getModalDelete: function (obj, delete_data, is_single) {
        if (!$('input[name="manage_url"]').length) {
            return false;
        }
        if (is_processing) {
            return false;
        }
        is_processing = true;

        var manage = $('input[name="manage_url"]').val();
        var url    = manage + '/delete';

        var is_trash = 0;
        if (obj.data('is-trash') == 1) {
            is_trash = 1;
        }

        url += "?is_trash=" + is_trash;

        $.ajax({
            url: url,
            data: {
                delete_ids: delete_data,
                data: obj.data(),
                [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
            },
            type: 'POST',
            beforeSend: function () {
                if (is_single) {
                    obj.find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                } else {
                    obj.find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
                }
            },
            complete: function () {
                if (is_single) {
                    obj.find('i').replaceWith('<i class="fas fa-trash-alt"></i>');
                } else {
                    obj.find('i').replaceWith('<i class="fas fa-trash-alt me-1"></i>');
                }
            },
            success: function (data) {

                is_processing = false;
                var response = JSON.stringify(data);
                response = JSON.parse(response);

                if (response.token) {
                    // Update CSRF hash
                    $("input[name*='" + csrf_token + "']").val(response.token);
                }

                if (response.status == 'ng') {
                    $.notify(response.msg, {'type':'danger'});
                    return false;
                } else if (response.status == 'redirect') {
                    window.location = response.url;
                    return false;
                }
                $('#modal_delete_confirm').remove();
                $('body').append('<div id="modal_delete_confirm" class="modal fade" role="dialog">' + response.data + '</div>');
                $('#modal_delete_confirm').modal('show');

            },
            error: function (xhr, errorType, error) {
                is_processing = false;
                $.notify({
                        message: xhr.responseJSON.message + " Please reload the page!!!",
                        url: window.location.href,
                        target: "_self",
                    }, 
                    {'type': 'danger'},
                );
            }
        });
    },
    submitDelete: function (form_id) {
        if (is_processing) {
            return false;
        }

        is_processing = true;
        $.ajax({
            url: $('#' + form_id).attr('action'),
            type: 'POST',
            data: $("#" + form_id).serialize(),
            beforeSend: function () {
                $('#' + form_id + ' #submit_delete').find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
            },
            complete: function () {
                $('#' + form_id + ' #submit_delete').find('i').replaceWith('<i class="fas fa-trash-alt me-1"></i>');
            },
            success: function (data) {
                is_processing = false;

                var response = JSON.stringify(data);
                response = JSON.parse(response);

                if (response.token) {
                    // Update CSRF hash
                    $("input[name*='" + csrf_token + "']").val(response.token);
                }

                if (response.status == 'redirect') {
                    window.location = response.url;
                    return false;
                } else if (response.status == 'ng') {
                    $.notify(response.msg, {'type': 'danger'});
                    return false;
                } else if (response.status == 'reload') {
                    location.reload();
                    return false;
                }

                $.each(response.ids, function(i, news_id) {
                    if (!$("tr#item_id_" + news_id).length) {
                        location.reload();
                        return false;
                    }
                    $("tr#item_id_" + news_id).remove('slow').fadeOut();
                    $("tr#item_id_" + news_id + " .btn_delete_single").tooltip('dispose');
                });

                $('#modal_delete_confirm').modal('hide');
                $.notify(response.msg);
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
                $.notify({
                        message: xhr.responseJSON.message + " Please reload the page!!!",
                        url: window.location.href,
                        target: "_self",
                    }, 
                    {'type': 'danger'},
                );
            }
        });
    },
    showDatetime: function () {
        if ($('.show-datetime-picker').length) {
            var option = {
                sideBySide: false,
                icons: {
                    time: "far fa-clock active",
                    date: "fa fa-calendar-alt",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
                daysOfWeekDisabled: [0, 6]
            };
            if ($('.show-datetime-picker').data('date-locale') == 'vi') {
                option = {
                    sideBySide: false,
                    icons: {
                        time: "far fa-clock active",
                        date: "fa fa-calendar-alt",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    daysOfWeekDisabled: [0, 6],
                    locale: 'vi',
                };
            }
            $('.show-datetime-picker').datetimepicker(option);
        }
    },
    showDate: function () {
        if ($('.show-date-picker').length) {
            var option = {
                sideBySide: false,
            };
            if ($('.show-date-picker').data('date-locale') == 'vi') {
                 option = {
                    sideBySide: false,
                    locale: 'vi',
                };
            }
            $('.show-date-picker').datetimepicker(option);
        }
    },
    showTime: function () {
        if ($('.show-time-picker').length) {
            $('.show-time-picker').datetimepicker({
                sideBySide: false,
                format: $('.show-time-picker').data('date-format'),
                pickDate: false,
                pickSeconds: false,
                pick12HourFormat: false
            });
        }
    },
    checkBoxPermission: function () {
        if (!$('input[name="cb_permission_all"]').length) {
            return false;
        }
        if (!$('input[name="permissions[]"]').length) {
            return false;
        }

        $(document).on('change', 'input[name="cb_permission_all"]', function() {
            $('input[name="permissions[]"]').prop('checked', $(this).prop("checked"));
        });

        $(document).on('change', 'input[name="permissions[]"]', function() {
            $('input[name="cb_permission_all"]').prop('checked', false);
            if ($('input[name="permissions[]"]:checked').length == $('input[name="permissions[]"]').length) {
                $('input[name="cb_permission_all"]').prop('checked', true);
            }
        });
    },
    changeCaptcha: function () {
        if (is_processing) {
            return false;
        }
        if (!$('.js-re-captcha').length) {
            return false;
        }

        is_processing = true;
        $.ajax({
            url: 'users/auth/recaptcha',
            type: 'POST',
            data: [],
            beforeSend: function () {
                $('.js-re-captcha').find('i').replaceWith('<i class="fas fa-spinner fa-spin me-2"></i>');
            },
            complete: function () {
                $('.js-re-captcha').find('i').replaceWith('<i class="fas fa-sync font-18"></i>');
            },
            success: function (data) {
                is_processing = false;

                var response = JSON.stringify(data);
                response = JSON.parse(response);
                $('#ci_captcha_image').html(response.captcha);
                $('#ci_captcha_image').fadeIn("slow");
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
            }
        });
    },
    scrollMenu: function (obj) {
        if ($('.nav-left-sidebar-scrolled').length) {
            $(".nav-left-sidebar").removeClass('nav-left-sidebar-scrolled');
            $(".dashboard-wrapper").removeClass('nav-left-sidebar-content-scrolled');
            $(".nav-left-sidebar .btn-scroll").addClass('btn-light');
            $(".nav-left-sidebar .btn-scroll").removeClass('btn-warning');
            $('.nav-left-sidebar .btn-scroll').find('i').replaceWith('<i class="fas fa-angle-double-left font-8"></i>');
        } else {
            $(".nav-left-sidebar").addClass('nav-left-sidebar-scrolled');
            $(".dashboard-wrapper").addClass('nav-left-sidebar-content-scrolled');
            $(".nav-left-sidebar .btn-scroll").removeClass('btn-light');
            $(".nav-left-sidebar .btn-scroll").addClass('btn-warning');
            $('.nav-left-sidebar .btn-scroll').find('i').replaceWith('<i class="fas fa-angle-double-right font-14 text-dark"></i>');
        }
    },
    setCookie: function (key, value, days) {
        var expires = new Date();
        if (days) {
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        } else {
            document.cookie = key + '=' + value + ';expires=Fri, 30 Dec 9999 23:59:59 GMT;';
        }
    },
    getCookie: function (key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    },
    showMenuFileManager: function () {
        if (is_processing) {
            return false;
        }
        is_processing = true;

        $('#modal_image').remove();//target=$element.parent().find('input').attr('id')
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

        $.ajax({
            async: true,
            url: 'common/filemanager',
            type: 'GET',
            //dataType: 'html',
            data: {is_show_lightbox: 1},
            success: function (html) {
                is_processing = false;
                $('.loading').remove().fadeOut();

                var response = JSON.stringify(html);
                response = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type': 'danger'});
                    return false;
                }

                if (response.redirect) {
                    location = response.redirect.replaceAll('&amp;', '&');
                    return false;
                }

                $('body').append('<div id="modal_image" class="modal fade" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">' + html + '</div>');

                $('html').css('overflow', 'hidden');
                $('#modal_image').modal('show');
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
                $('.loading').remove().fadeOut();
                $.notify({
                        message: xhr.responseJSON.message + " Please reload the page!!!",
                        url: window.location.href,
                        target: "_self",
                    }, 
                    {'type': 'danger'},
                );
            }
        });
        return false;
    },
    cropImage: function (url, preserve_aspect_ratio, obj) {
        if (is_processing) {
            return false;
        }
        is_processing = true;

        $('#cropper_html').remove();
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

        $('body').find('.image-crop-target').removeClass('image-crop-target');
        $(obj).parent().parent().addClass('image-crop-target');

        $.ajax({
            url: 'image/crop',
            data: {
                image_url: url,
                preserve_aspect_ratio: preserve_aspect_ratio,
            },
            dataType: 'html',
            success: function (html) {
                is_processing = false;
                $('.loading').remove().fadeOut();

                var response = JSON.stringify(html);
                response = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type': 'danger'});
                    return false;
                }

                $('body').append('<div id="cropper_html">' + html + '</div>');
                $('#modal_image_crop').modal('toggle');
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
                $('.loading').remove().fadeOut();
                $.notify({
                        message: xhr.responseJSON.message + " Please reload the page!!!",
                        url: window.location.href,
                        target: "_self",
                    }, 
                    {'type': 'danger'},
                );
            }
        });
        return false;
    },
    showRangeValue: function (obj) {
        if (!$(obj).data("target").length) {
            return;
        }
        $($(obj).data("target")).html($(obj).val());
    },
    submitFormAjax: function (e) {

        if (is_processing) {
            return false;
        }
        is_processing = true;

        e.preventDefault();

        var element = this;

        var form = e.target;

        var action = $(form).attr('action');

        if (e.originalEvent !== undefined && e.originalEvent.submitter !== undefined) {
            var button = e.originalEvent.submitter;
        } else {
            var button = '';
        }

        var method = $(form).attr('method');

        if (method === undefined) {
            method = 'post';
        }

        var enctype = $(element).attr('enctype');

        if (enctype === undefined) {
            enctype = 'application/x-www-form-urlencoded';
        }

        // https://github.com/opencart/opencart/issues/9690
        // if (typeof CKEDITOR != 'undefined') {
        //     for (instance in CKEDITOR.instances) {
        //         CKEDITOR.instances[instance].updateElement();
        //     }
        // }

        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

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
                $(button).find('i').replaceWith('<i class="fas fa-save me-1"></i>');
                //$(button).prop('disabled', false).removeClass('loading');
            },
            success: function (json) {
                $('.loading').remove().fadeOut();
                is_processing = false;

               // $('.alert-dismissible').remove();
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

                        $.notify(json['error'][key], {'type': 'danger'});
                    }
                }

                if (json['success']) {
                    $.notify(json['success']);

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
                $.notify({
                        message: xhr.responseJSON.message + " Please reload the page!!!",
                        url: window.location.href,
                        target: "_self",
                    },
                    {'type': 'danger'},
                );
            }
        });

        return false;
    },
};

/* action - event */
$(function () {

    $(window).on('load', function () {
        $('.loading').fadeOut();
        $('#page_loading').fadeOut();
    });

    //time out 4s
    setTimeout(function(){
        $('#page_loading').fadeOut();


    }, 4000);

    if (!$(".nav-left-sidebar").length) {
        $('.dashboard-main-wrapper').find('.dashboard-wrapper').removeClass(['dashboard-wrapper', 'navbar-full-text-content']).removeClass('nav-left-sidebar-content-scrolled');
    }

    if ($('.make-slug').length) {
        $(".make-slug").on("keyup", function () {
            Catcool.makeSlug(this);
        });
    }

    $('a[href="#"]').click(function(e) {
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
    });

    if ($('.change_publish').length) {
        $(document).on('change', '.change_publish', function(e) {
            e.preventDefault();
            Catcool.changePublish(this);
        });
    }

    $(document).on('click', '#menu_file_manager, .show-file-manager', function(e) {
        e.preventDefault();
        Catcool.showMenuFileManager();
        return false;
    });

    $(document).on('submit', 'form[data-cc-toggle=\'ajax\']', function (e) {
        Catcool.submitFormAjax(e);
    });

    $(document).on('hidden.bs.modal, hide.bs.modal','#modal_image', function () {
        $('html').css('overflow', '');
    });

    if ($("form").length) {
        //stop enter in form
        // $("form").on("keypress", function (e) {
        //     var keyPressed = e.keyCode || e.which;
        //     if (keyPressed === 13) {
        //         e.preventDefault();
        //         return false;
        //     }
        // });
    }

    //khong cho leave page khi dang edit
    if ($(".form-confirm-leave").length) {
        $('.form-confirm-leave form').data('serialize',$('.form-confirm-leave form').serialize()); // On load save form current state
        $(window).bind('beforeunload', function(e) {
            if($('.form-confirm-leave form').serialize()!= $('.form-confirm-leave form').data('serialize')) {
                return true;
            }
            else {
                e = null;
            } // i.e; if form state change show warning box, else don't show it.

        });
        $(document).on('click', '.form-confirm-leave .btn', function() {
            $(window).unbind('beforeunload');
        });
    }

    /* set gia tri mac dinh */
    $.notifyDefaults({
        type: 'success',
        placement: {
            from: 'top',
            align: 'right'
        },
        template: '<div data-notify="container" class="mx-2 alert alert-{0} alert-dismissible" role="alert"><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
    });
    /* load alert neu ton tai session */
    if ($('input[name="alert_msg[]"]').length) {
        $('input[name="alert_msg[]"]').each(function(){
            $.notify($(this).val(),{type: $(this).data('type')});
        });
    }

    Catcool.checkBoxDelete();
    Catcool.deleteSingle();
    Catcool.showDatetime();
    Catcool.showDate();//only date
    Catcool.showTime();//only time
    Catcool.checkBoxPermission();

    $(document).on("click", '[data-toggle=\'lightbox\']', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    if ($('[data-bs-toggle=\'popover\']').length) {
        $('[data-bs-toggle=\'popover\']').popover('dispose');
        $('[data-bs-toggle=\'popover\']').popover();
    }

    // Tooltip
    var oc_tooltip = function () {
        // Apply to all on current page
        tooltip = bootstrap.Tooltip.getOrCreateInstance(this);
        tooltip.show();
    }

    $(document).on('mouseenter', '[data-bs-toggle=\'tooltip\']', oc_tooltip);

    $(document).on('click', 'button', function () {
        $('.tooltip').remove();
    });

    if ($('[data-bs-toggle=\'tooltip\']').length) {
        $('[data-bs-toggle=\'tooltip\']').tooltip('dispose');
        $('[data-bs-toggle=\'tooltip\']').tooltip();
    }
    // end Tooltip

    if ($('#btn_search').length) {
        $(document).on('click','#btn_search', function () {
            $($('#btn_search').data('target')).collapse('toggle');
        });
    }

    if ($('.cc-form-select-single').length) {
        $('.cc-form-select-single').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            selectionCssClass: 'select2--small',
            dropdownCssClass: 'select2--small',
        });
    }

    if ($('.cc-form-select-multi').length) {
        $('.cc-form-select-multi').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
            //allowClear: true,
            selectionCssClass: 'select2--small',
            dropdownCssClass: 'select2--small',
        });
    }

    // ==============================================================
    // Notification list
    // ==============================================================
    if ($(".notification-list").length) {
        $('.notification-list').slimScroll({
            height: '250px'
        });
    }

    // ==============================================================
    // Menu Slim Scroll List
    // ==============================================================
    if ($(".navbar-full-text .menu-list").length) {
        $('.navbar-full-text .menu-list').slimScroll({

        });
    }
    // ==============================================================
    // Sidebar scrollnavigation
    // ==============================================================
    if ($(".navbar-full-text .menu-list a").length) {
        $('.navbar-full-text .menu-list a').click(function(event) {
            $('.navbar-full-text .menu-list a').each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });
    }

    // ===================
    // SEO
    // ===================
    Catcool.checkLoadContentSeo();

    // Turn of Progress bar on
    //$.notify('I have a progress bar', { showProgressbar: true });

    if ($('.color-picker').length) {
        $('.color-picker').each(function() {
            //
            // Dear reader, it's actually very easy to initialize MiniColors. For example:
            //
            //  $(selector).minicolors();
            //
            // The way I've done it below is just for the demo, so don't get confused
            // by it. Also, data- attributes aren't supported at this time...they're
            // only used for this demo.
            //
            $(this).minicolors({
                control: $(this).data('control') || 'hue',
                defaultValue: $(this).data('defaultValue') || '',
                format: $(this).data('format') || 'hex',
                keywords: $(this).data('keywords') || '',
                inline: $(this).data('inline') === 'true',
                letterCase: $(this).data('letterCase') || 'lowercase',
                opacity: $(this).data('opacity'),
                position: $(this).data('position') || 'bottom left',
                swatches: $(this).data('swatches') ? $(this).data('swatches').split('|') : [],
                change: function(value, opacity) {
                    if (!value) return;
                    if (opacity) value += ', ' + opacity;
                    if (typeof console === 'object') {
                        console.log(value);
                    }
                },
                theme: 'bootstrap'
            });
        });
    }

    //check double click form
    if (!$("form[data-cc-toggle=\'ajax\']").length) {
        $("form#validationform").submit(function() {
            $(this).submit(function() {
                return false;
            });
            $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
            return true;
        });
    }

    //hien thi button save scroll
    $(window).trigger('scroll');
    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > 50) {
            $('#form_btn_save_fixed').addClass('form-btn-save-fixed');
        } else {
            $('#form_btn_save_fixed').removeClass('form-btn-save-fixed');
        }
    });

    //sort hình
    if ($('.sortable_photos').length) {
        var sortable_photo = Sortable.create($('.sortable_photos')[0],{
            //animation: 100,
            onSort: function (/**Event*/evt) {
                // same properties as onEnd
                //alert(335);
            },
        });
    }

    if ($('.sortable-catcool').length) {
        var sortable_catcool = Sortable.create($('.sortable-catcool')[0],{
            animation: 100,
            onSort: function (/**Event*/evt) {
                // same properties as onEnd
                //alert(335);
            },
        });
    }
});
