
var is_uploading = false;
var Photo = {
    loadImageReview: function (image_form_id) {

        $(document).on('dragover', 'html', function(e) {
            e.preventDefault();
            e.stopPropagation();
            /*$("h5").text("Drag here");*/
        });
        $(document).on('drop', 'html', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
        $(document).on('dragenter', '.upload-area', function(e) {
            e.stopPropagation();
            e.preventDefault();
            /*$("h5").text("Drop");*/
        });
        $(document).on('dragover', '.upload-area', function(e) {
            e.stopPropagation();
            e.preventDefault();
        });

        // Drop
        $(document).on('drop', image_form_id, function(e) {
            e.stopPropagation();
            e.preventDefault();
//            document.querySelector('#file').files = e.originalEvent.dataTransfer.files;
//           document.querySelector('#file_photos_' + num).files =  new FileListItem(file_tmp); set value den input file

            var file = e.originalEvent.dataTransfer.files;
            var formdata = new FormData();

            if (file.length > 0) {
                for (var i = 0; i < file.length; i++) {
                    formdata.append("files[]", file[i]);
                }

                Photo.uploadData(formdata, image_form_id);
            }

            //Photo.imagesPreview(e.originalEvent.dataTransfer);
        });

        // Open file selector on div click
        $(document).on('click', image_form_id + " .drop-drap-file .upload-area", function(e) {
            e.stopPropagation();
            e.preventDefault();
            $(image_form_id + " .drop-drap-file #file").click();

        });

        // file selected
        $(document).on('change', image_form_id + " .drop-drap-file #file", function(e) {
            e.stopPropagation();
            e.preventDefault();

            var formdata = new FormData();
            var files = $(image_form_id + ' #file');
            for (var i = 0; i < this.files.length; i++) {
                formdata.append("files[]", files[0].files[i]);
            }
            Photo.uploadData(formdata, image_form_id);
        });
    },
    uploadData: function (formdata, image_form_id) {
        if (is_uploading) {
            return false;
        }

        var is_multi = $(image_form_id + ' .drop-drap-file').attr("data-is-multi");
        if (typeof(is_multi) != 'undefined' && is_multi == 'multiple') {
            formdata.append("is_multi", true);
        }

        var progress = '<div class="progress">';
        progress += '<div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width: 0%"></div>';
        progress += '</div>';
        $(image_form_id + ' .drop-drap-file').append(progress);

        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function() {
            clearInterval(timer);

            is_uploading = true;
            $.ajax({
                url: 'photos/manage/do_upload',
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                dataType: 'json',
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);

                            $('#progress-bar').attr("aria-valuenow", percentComplete);
                            $('#progress-bar').attr("style", 'width: ' + percentComplete + '%;');
                        }
                    }, false);

                    return xhr;
                },
                success: function (data) {
                    is_uploading = false;

                    $('.drop-drap-file .progress').remove().fadeOut();

                    var response = JSON.stringify(data);
                    response = JSON.parse(response);
                    if (response.status == 'ng') {
                        $.notify(response.msg, {'type': 'danger'});
                        return false;
                    }
                    if (typeof(is_multi) != 'undefined' && is_multi == 'multiple') {
                        $(image_form_id + ' #image_thumb').append(response.image);
                    } else {
                        $(image_form_id + ' #image_thumb').html('');
                        $(image_form_id +' #image_thumb').html(response.image);
                    }

                    if ($(image_form_id + " #button-image-crop").length) {
                        $(image_form_id + " #button-image-crop").attr("onclick", "Catcool.cropImage('" + response.image_url  + "', 0);");
                        $(image_form_id + " #button-image-crop").show();
                    }

                    $(image_form_id + ' #image_thumb').focus();
                },
                error: function (xhr, errorType, error) {
                    is_uploading = false;
                    $('.drop-drap-file .progress').remove().fadeOut();
                    $.notify('System Error!', {'type': 'danger'});
                }
            });
        }, 500);
    },
    delete_div_photo: function (obj) {
        if (is_uploading) {
            return false;
        }
        if ($('input[name="confirm_title"]').length) {
            var confirm_title = $('input[name="confirm_title"]').val();
        }
        if ($('input[name="confirm_content"]').length) {
            var confirm_content = $('input[name="confirm_content"]').val();
        }
        if ($('input[name="confirm_btn_ok"]').length) {
            var confirm_btn_ok = $('input[name="confirm_btn_ok"]').val();
        }
        if ($('input[name="confirm_btn_close"]').length) {
            var confirm_btn_close = $('input[name="confirm_btn_close"]').val();
        }
        $.confirm({
            title: confirm_title,
            content: confirm_content,
            icon: 'fa fa-question',
            columnClass: 'col-md-6 col-md-offset-3',
            //theme: 'bootstrap',
            closeIcon: true,
            //animation: 'scale',
            typeAnimated: true,
            type: 'red',
            buttons: {
                formSubmit: {
                    text: confirm_btn_ok,
                    btnClass: 'btn-danger',
                    keys: ['y', 'enter', 'shift'],
                    action: function(){
                        var image_key = $(obj).attr("data-photo_key");
                        $('#photo_key_' + image_key).remove().fadeOut();
                    }
                },
                cancel: {
                    text: confirm_btn_close,
                    keys: ['n']
                },
            }
        });
    },
    submitAlbum: function (form_id, is_edit) {
        if (is_uploading) {
            return false;
        }
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
        is_uploading = true;
        $('[data-toggle=\'tooltip\']').tooltip('dispose');
        $('[role=\'tooltip\']').remove();
        $('[data-toggle=\'tooltip\']').tooltip();
        $.ajax({
            url: $('#' + form_id).attr('action'),
            type: 'POST',
            data: $("#" + form_id).serialize(),
            success: function (data) {
                is_uploading = false;
                $('.loading').remove().fadeOut();
                var response = JSON.stringify(data);
                response = JSON.parse(response);

                if (response.status == 'redirect') {
                    window.location = response.url;
                    return false;
                } else if (response.status == 'ng') {
                    $.notify(response.msg, {'type': 'danger'});
                    return false;
                }

                if (is_edit == true) {
                    $.notify(response.msg);
                }

                var edit_url = 'photos/albums_manage/edit/' + response.id;
                Photo.loadView(edit_url);

                //location.reload();
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').remove().fadeOut();
            }
        });

        return false;
    },
    loadView: function (url, formdata) {
        history.pushState(null, '', url);

        $('[data-toggle="tooltip"]').tooltip('hide');
        $('[role=\'tooltip\']').remove();

        if (!$('#view_albums').length && !$('#view_photos').length) {
            window.location = url;
        }

        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

        $.ajax({
            url: url,
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: true,
            dataType: 'json',
            success: function (data) {
                is_uploading = false;
                $('.loading').remove().fadeOut();
                var response = JSON.stringify(data);
                response = JSON.parse(response);

                if (response.status == 'redirect') {
                    window.location = response.url;
                    return false;
                } else if (response.status == 'ng') {
                    $.notify(response.msg, {'type': 'danger'});
                    return false;
                }
                if (typeof(response.view) == 'undefined' || response.view == null) {
                    window.location = url;
                }

                if ($('#view_photos').length) {
                    $('#view_photos').html(response.view);
                } else {
                    $('#view_albums').html(response.view);
                }

                $('[data-toggle="tooltip"]').tooltip();

                if ($('.sortable_photos').length) {
                    var sortable = Sortable.create($('.sortable_photos')[0]);
                }
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').remove().fadeOut();
                window.location = url;
            }
        });
    },
    submitPhoto: function (form_id, is_edit) {
        if (is_uploading) {
            return false;
        }
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
        is_uploading = true;

        $('[data-toggle="tooltip"]').tooltip('hide');
        $('[role=\'tooltip\']').remove();

        $.ajax({
            url: $('#' + form_id).attr('action'),
            type: 'POST',
            data: $("#" + form_id).serialize(),
            beforeSend: function () {
                $('#' + form_id + ' #submit_photo').find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
            },
            complete: function () {
                $('#' + form_id + ' #submit_photo').find('i').replaceWith('<i class="fas fa-save"></i>');
            },
            success: function (data) {
                is_uploading = false;
                $('.loading').remove().fadeOut();

                var response = JSON.stringify(data);
                response = JSON.parse(response);

                if (response.status == 'redirect') {
                    window.location = response.url;
                    return false;
                } else if (response.status == 'ng') {
                    $.notify(response.msg, {'type': 'danger'});
                    return false;
                }

                $.notify(response.msg);
                $('#view_photos').attr('data-reload', 'true');

                if ($('#view_albums').length) {
                    $('#view_albums').attr('data-reload', 'true');
                }

                if($('#token_content_photo').length && response.token != '') {
                    $('#token_content_photo').html(response.token);
                }

                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').remove().fadeOut();
            }
        });

        return false;
    },
    loadViewModal: function (url, id_edit) {
        //history.pushState(null, '', url);
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

        $('[data-toggle="tooltip"]').tooltip('hide');
        $('[role=\'tooltip\']').remove();
        $('#load_view_modal #formPhotoModal').remove();
        $('#view_photos').removeAttr('data-reload');
        $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            processData: true,
            dataType: 'json',
            beforeSend: function () {
                if (id_edit) {
                    $('#btn_photo_zoom_' + id_edit).find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                } else {
                    $('#btn_photo_add').find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                }
            },
            complete: function () {
                if (id_edit) {
                    $('#btn_photo_zoom_' + id_edit).find('i').replaceWith('<i class="fas fa-search-plus"></i>');
                } else {
                    $('#btn_photo_add').find('i').replaceWith('<i class="fas fa-plus"></i>');
                }
            },
            success: function (data) {
                is_uploading = false;
                $('.loading').remove().fadeOut();
                var response = JSON.stringify(data);
                response = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type': 'danger'});
                    return false;
                } else if (response.status == 'redirect') {
                    window.location = response.url;
                    return false;
                }
                if (typeof(response.view) == 'undefined' || response.view == null) {
                    window.location = url;
                }

                $('#load_view_modal').html(response.view);

                //reload tags
                if ($('#tags').length) {
                    $('#tags').tagsinput();
                }
                $('#load_view_modal #formPhotoModal').modal("toggle");

                $('.tooltip').remove();
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').remove().fadeOut();
                window.location = url;
            }
        });
    },
    // Bytes conversion
    convertSize: function (size) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (size == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
        return Math.round(size / Math.pow(1024, i), 2) + ' ' + sizes[i];
    },
    photoAddModal: function (obj) {
        Photo.loadViewModal('photos/manage/add');
    },
    photoEditModal: function (id) {
        Photo.loadViewModal('photos/manage/edit/' + id, id);
        // setTimeout(function(){
        //     Photo.loadImageReview('#formPhotoModal');//khoi tao drop image
        // },500);

    },
};

// Used for creating a new FileList in a round-about way
    function FileListItem(a) {
        a = [].slice.call(Array.isArray(a) ? a : arguments)
        for (var c, b = c = a.length, d = !0; b-- && d;) d = a[b] instanceof File
        if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
        for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(a[c])
        return b.files
    }

$(function () {

    Photo.loadImageReview('#form_drop_album');//khoi tao drop image
    Photo.loadImageReview('#formPhotoModal');//khoi tao drop image

    if ($('.sortable_photos').length) {
        var sortable = Sortable.create($('.sortable_photos')[0],{
            //animation: 100,
            onSort: function (/**Event*/evt) {
                // same properties as onEnd
                //alert(335);
            },
        });
    }

    $(document).on('hidden.bs.modal', '#load_view_modal #formPhotoModal', function() {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        if ($('#view_photos').attr('data-reload') == 'true') {
            Photo.loadView('photos/manage' + $('#view_photos').attr('data-parameter'));
        } else if ($('#view_albums').attr('data-reload') == 'true') {
            $('#view_albums').attr('data-reload', 'false');
            Photo.loadView($(location).attr('href'));
        }
    })
});
