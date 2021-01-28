var is_processing = false;
var Catcool = {
    makeSlug: function(obj) {
        var text_slug = $(obj).val();
        text_slug = Catcool.convertSlug(text_slug);

        if ($('#' + $(obj).attr("data-slug-id")).length) {
            $('#' + $(obj).attr("data-slug-id")).attr('placeholder', text_slug);
        }

        if ($('#' + $(obj).attr("data-preview-slug")).length && !$('#' + $(obj).attr("data-slug-id")).val().length) {
            $('#' + $(obj).attr("data-preview-slug")).html(text_slug);
        }

        if ($('#' + $(obj).attr("data-title-id")).length) {
            $('#' + $(obj).attr("data-title-id")).attr('placeholder', $(obj).val());
        }

        if ($('#' + $(obj).attr("data-preview-title")).length && !$('#' + $(obj).attr("data-preview-title")).val().length) {
            $('#' + $(obj).attr("data-preview-title")).html($(obj).val());
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
        if (!$('#' + $(obj).attr("data-seo-id")).length) {
            return;
        }

        var text_seo = "";
        if ($(obj).val().length) {
            text_seo = $(obj).val();
        }
        // else if ($(obj).attr('placeholder')){
        //     text_seo = $(obj).attr('placeholder');
        // }

        if ($(obj).attr("data-is-slug")) {
            text_seo = Catcool.convertSlug(text_seo);
            $(obj).val(text_seo);
        }

        $('.preview-meta-seo').show();
        $('#' + $(obj).attr("data-seo-id")).html(text_seo);

        var length_id = $(obj).attr("data-seo-id") + '_length';
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
            var length_id = $(this).attr('data-target');
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
        var id       = $(obj).attr("data-id");
        var is_check = 0;
        var url_api  = manage + '/publish';

        if ($(obj).is(':checked')) {
            is_check = 1;
        }

        is_processing = true;
        $.ajax({
            url: url_api,
            data: {'id' : id, 'published': is_check},
            type:'POST',
            success: function (data) {
                is_processing = false;

                var response = JSON.stringify(data);
                response = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type':'danger'});
                    $(obj).prop("checked", $(obj).attr("value"));
                    return false;
                }
                $.notify(response.msg);
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
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
            $('#delete_multiple').show();
            $('input[name="manage_ids[]"]').prop('checked', $(this).prop("checked"));
            if (!$('input[name="manage_ids[]"]:checked').length) {
                $('#delete_multiple').hide();
            }
        });
        $(document).on('change', 'input[name="manage_ids[]"]', function() {
            $('input[name="manage_ids[]"]').each(function(){
                if($(this).is(":checked")) {
                    $('#delete_multiple').show();
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
            Catcool.getModalDelete(element, element.attr('data-id'));
        });
    },
    getModalDelete: function (obj, delete_data) {
        if (!$('input[name="manage_url"]').length || !delete_data.length) {
            return false;
        }
        if (is_processing) {
            return false;
        }
        is_processing = true;
        $('[data-toggle=\'tooltip\']').tooltip('dispose');
        $('[data-toggle=\'tooltip\']').tooltip();
        var manage = $('input[name="manage_url"]').val();
        var url    = manage + '/delete';
        $.ajax({
            url: url,
            data: {delete_ids: delete_data},
            type: 'POST',
            beforeSend: function () {
                obj.find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
            },
            complete: function () {
                obj.find('i').replaceWith('<i class="fas fa-trash-alt"></i>');
            },
            success: function (data) {
                is_processing = false;
                var response = JSON.stringify(data);
                response = JSON.parse(response);
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
                obj.tooltip('hide');
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
            }
        });
    },
    submitDelete: function (form_id) {
        if (is_processing) {
            return false;
        }
        $('[data-toggle=\'tooltip\']').tooltip('dispose');
        $('[data-toggle=\'tooltip\']').tooltip();
        is_processing = true;
        $.ajax({
            url: $('#' + form_id).attr('action'),
            type: 'POST',
            data: $("#" + form_id).serialize(),
            beforeSend: function () {
                $('#' + form_id + ' #submit_delete').find('i').replaceWith('<i class="fas fa-spinner fa-spin me-2"></i>');
            },
            complete: function () {
                $('#' + form_id + ' #submit_delete').find('i').replaceWith('<i class="fas fa-trash-alt me-2"></i>');
            },
            success: function (data) {
                is_processing = false;

                var response = JSON.stringify(data);
                response = JSON.parse(response);

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

                $.notify(response.msg);
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
            }
        });
    },
    showDatetime: function () {
        if ($('.show-datetime-picker').length) {
            $('.show-datetime-picker').datetimepicker({
                sideBySide: false,
                format: $('.show-datetime-picker').attr('data-date-format'),
                icons: {
                    time: "far fa-clock active",
                    date: "fa fa-calendar-alt",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
                daysOfWeekDisabled: [0, 6]
            });
        }
    },
    showDate: function () {
        if ($('.show-date-picker').length) {
            $('.show-date-picker').datetimepicker({
                sideBySide: false,
                format: $('.show-date-picker').attr('data-date-format'),
            });
        }
    },
    showTime: function () {
        if ($('.show-time-picker').length) {
            $('.show-time-picker').datetimepicker({
                sideBySide: false,
                format: $('.show-time-picker').attr('data-date-format'),
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
            $('.nav-left-sidebar .btn-scroll').find('i').replaceWith('<i class="fas fa-angle-double-left font-22"></i>');
        } else {
            $(".nav-left-sidebar").addClass('nav-left-sidebar-scrolled');
            $(".dashboard-wrapper").addClass('nav-left-sidebar-content-scrolled');
            $(".nav-left-sidebar .btn-scroll").removeClass('btn-light');
            $(".nav-left-sidebar .btn-scroll").addClass('btn-warning');
            $('.nav-left-sidebar .btn-scroll').find('i').replaceWith('<i class="fas fa-angle-double-right font-20 text-dark"></i>');
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
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $('#modal-image').remove();//target=$element.parent().find('input').attr('id')
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

                $('body').append('<div id="modal-image" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">' + html + '</div>');

                $('#modal-image').modal('show');
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
                $('.loading').remove().fadeOut();
            }
        });
        return false;
    },
    cropImage: function (url, preserve_aspect_ratio) {
        if (is_processing) {
            return false;
        }
        is_processing = true;

        $('#cropper_html').remove();
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

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
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
                $('.loading').remove().fadeOut();
            }
        });
        return false;
    },
    cropImage_BK: function (url, is_filemanager) {
        if (is_processing) {
            return false;
        }
        is_processing = true;

        $('#cropper_html').remove();
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

        $.ajax({
            url: 'images/crop',
            data: {image_url: url},
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
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
                $('.loading').remove().fadeOut();
            }
        });
        return false;
    },
};

/* action - event */
$(function () {

    $('.loading').fadeOut();

    if ($('.make_slug').length) {
        $(".make_slug").on("keyup", function () {
            Catcool.makeSlug(this);
        });
    }

    $('a[href="#"]').click(function(e) {
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
    });

    if ($('.change_publish').length) {
        $(document).on('change', '.change_publish', function(event) {
            event.preventDefault();
            Catcool.changePublish(this);
        });
    }

    /* set gia tri mac dinh */
    $.notifyDefaults({
        type: 'success',
        placement: {
            from: 'top',
            align: 'center'
        }
    });
    /* load alert neu ton tai session */
    if ($('input[name="alert_msg[]"]').length) {
        $('input[name="alert_msg[]"]').each(function(){
            $.notify($(this).val(),{type: $(this).attr('data-type')});
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

    // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    // var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    //     return new bootstrap.Tooltip(tooltipTriggerEl)
    // })

    if ($('[data-bs-toggle=\'tooltip\']').length) {
        $('[data-bs-toggle=\'tooltip\']').tooltip('dispose');
        $('[data-bs-toggle=\'tooltip\']').tooltip();
    }
    if ($('[data-toggle=\'popover\']').length) {
        $('[data-toggle=\'popover\']').popover('dispose')
        $('[data-toggle=\'popover\']').popover()
    }

    if ($('#btn_search').length) {
        $(document).on('click','#btn_search', function () {
            $($('#btn_search').attr('data-target')).collapse('toggle');
            $('#btn_search').tooltip('hide');
        });
    }

    if ($('.selectpicker').length) {
        $('.selectpicker').selectpicker();
        if ($('#category_review').length) {
            $('.selectpicker').change(function () {
                var selected_text = $(this).find('option:selected').map(function () {
                    return $(this).text();
                }).get().join(',');

                $('#category_review ul').remove();
                $('#category_review').append('<ul class="list-unstyled bullet-check mb-0"></ul>');
                var text_select_array = selected_text.split(',');
                if (text_select_array.length && text_select_array != "") {
                    for (i = 0; i < text_select_array.length; i++) {
                        $('#category_review ul').append('<li>' + text_select_array[i] + '</li>');
                    }
                }
            });
        }
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
                control: $(this).attr('data-control') || 'hue',
                defaultValue: $(this).attr('data-defaultValue') || '',
                format: $(this).attr('data-format') || 'hex',
                keywords: $(this).attr('data-keywords') || '',
                inline: $(this).attr('data-inline') === 'true',
                letterCase: $(this).attr('data-letterCase') || 'lowercase',
                opacity: $(this).attr('data-opacity'),
                position: $(this).attr('data-position') || 'bottom left',
                swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
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

});

