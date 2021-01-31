{capture name="content_filemanager"}
    <div class="row">
        <div class="col-sm-8 col-12 mb-1">
            <a href="{$parent}" title="{$button_parent}" id="button_parent" class="btn btn-sm btn-light mb-2"><i class="fas fa-level-up-alt"></i></a>
            <a href="{$refresh}" title="{$button_refresh}" id="button_refresh" class="btn btn-sm btn-secondary mb-2"><i class="fas fa-sync me-2"></i>{$button_refresh}</a>
            <button type="button" title="{$button_upload}" id="button-upload" class="btn btn-sm btn-primary mb-2"><i class="fas fa-upload me-2"></i>{$button_upload}</button>
            <button type="button" title="{$button_folder}" id="button_folder" class="btn btn-sm btn-success mb-2"><i class="fas fa-folder me-2"></i>{$button_folder}</button>
            <button type="button" title="{$button_delete}" id="button_delete" class="btn btn-sm btn-danger mb-2"><i class="fas fa-trash me-2"></i>{$button_delete}</button>
            <a href="{base_url('image/editor')}" title="Photo Editor" class="btn btn-sm btn-warning mb-2"><i class="fas fa-pencil-alt me-2"></i>Photo Editor</a>
        </div>
        <div class="col-sm-4 col-12 mb-1">
            <div class="input-group">
                <input type="text" name="search" value="{$filter_name}" placeholder="{$entry_search}" class="form-control">
                <button type="button" title="{$button_search}" id="button_search" class="btn btn-sm btn-primary">{$button_search}</button>
            </div>
        </div>
    </div>
    <hr />
    <div id="msg" class="text-secondary"></div>
    <div class="row" id="filemanager_list">
        {foreach $images as $key => $image}
            <div class="col-xl-1 col-lg-2 col-md-2 col-sm-3 col-4 mb-2 text-center position-relative">
                {if $image.type == 'directory'}
                    <div class="text-center"><a href="{$image.href}" class="directory" style="vertical-align: middle;"><i class="fas fa-folder fa-4x"></i></a></div>
                    <p class="mt-1">
                        <input type="checkbox" name="path[]" value="{$image.path}" />
                        {$image.name}
                    </p>
                {elseif $image.type == 'image'}
                    <a href="{$image.thumb}" target="_blank" {if empty($target) && !empty($is_show_lightbox)}data-lightbox="photos"{/if} class="thumbnail">
                        <img src="{$image.thumb}" style="background-image: url('{$image.thumb}');" alt="{$image.name}" title="{$image.name}" class="img-thumbnail img-fluid img-photo-list" />
                    </a>
                    <p class="mt-1">
                        <input type="checkbox" name="path[]" value="{$image.path}" />
                        {$image.name}
                    </p>
                    <button type="button" class="btn btn-xs btn-primary image-setting shadow-sm" data-bs-toggle="popover"><i class="fas fa-ellipsis-h"></i></button>
                {elseif $image.type == 'video'}
                    <div class="text-center">
                        <video controls height="60" width="90" >
                            <source src="{$image.href}" type="video/mp4">
                            <source src="{$image.href}" type="video/webm">
                            <source src="{$image.href}" type="video/avi">
                            <source src="{$image.href}" type="video/ogg">
                            <p>Your browser doesn't support HTML5 video. Here is
                                a <a href="{$image.href}">link to the video</a> instead.</p>
                        </video>
                    </div>
                    <p class="mt-1">
                        <input type="checkbox" name="path[]" value="{$image.path}" />
                        {$image.name}
                    </p>
                {else}
                    <a href="{$image.href}" target="_blank" class="thumbnail" style="vertical-align: middle;"><i class="{$image.class}"></i></a>
                    <p class="mt-1">
                        <input type="checkbox" name="path[]" value="{$image.path}" />
                        {$image.name}
                    </p>
                {/if}
            </div>
        {/foreach}
    </div>
{/capture}

<div id="filemanager" class="modal-dialog modal-xl px-4" style="max-width: 100% !important;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="photoModalLabel">{$heading_title}{if !empty($directory)} ({$directory|urldecode}){/if}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
            {$smarty.capture.content_filemanager}
        </div>
        <div class="modal-footer">
            <nav aria-label="Page navigation" class="table-responsive text-center"><ul class="pagination p-0 m-0">{$pagination}</ul></nav>
        </div>
    </div>
</div>

{if $thumb}{form_hidden('file_thumb', $thumb)}{/if}
{if $target}{form_hidden('file_target', $target)}{/if}
<script type="text/javascript">
    var is_processing = false;
    var is_disposing = false;

    if ($('input[name=\'file_target\']').length) {
        $('a.thumbnail').on('click', function (e) {
            e.preventDefault();
            if ($('input[name=\'file_thumb\']').length) {
                $('#' + $('input[name=\'file_thumb\']').val()).attr('src', $(this).find('img').attr('src'));
            }
            $('#' + $('input[name=\'file_target\']').val()).val($(this).parent().find('input').val());
            $('#modal_image').modal('hide');
        });
    }

    $('a.directory').on('click', function(e) {
        filemanager_dispose_all();
        e.preventDefault();
        $('#modal_image').load($(this).attr('href'));
    });
    $('.pagination a').on('click', function(e) {
        filemanager_dispose_all();
        e.preventDefault();
        $('#modal_image').load($(this).attr('href'));
    });
    $('#button_parent').on('click', function(e) {
        filemanager_dispose_all();
        e.preventDefault();
        $('#modal_image').load($(this).attr('href'));
    });
    $('#button_refresh').on('click', function(e) {
        if (is_processing) {
            return false;
        }
        is_processing = true;
        filemanager_dispose_all();
        e.preventDefault();
        $('#modal_image').load($(this).attr('href'));
    });
    $('input[name=\'search\']').on('keydown', function(e) {
        if (e.which == 13) {
            $('#button_search').trigger('click');
        }
    });

    $('#button_search').on('click', function(e) {
        filemanager_dispose_all();
        var url = base_url + '/common/filemanager?directory={{$directory}}';
        var filter_name = $('input[name=\'search\']').val();
        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        } else {
            $.notify('{{$error_search_null}}', {
                'type':'danger'
            });
            return false;
        }

        if ($('input[name=\'file_thumb\']').length) {
            url += '&thumb=' + $('input[name=\'file_thumb\']').val();
        }
        if ($('input[name=\'file_target\']').length) {
            url += '&target=' + $('input[name=\'file_target\']').val();
        }

        $('#modal_image').load(url);
    });

    $('#button-upload').on('click', function() {
        filemanager_dispose_all();

        $('#form-upload').remove();
        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" id="files" name="file[]" value="" multiple="multiple" /></form>');
        $('#form-upload input[name=\'file[]\']').trigger('click');
        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }
        timer = setInterval(function() {
            if ($('#form-upload input[name=\'file[]\']').val() != '') {
                clearInterval(timer);
                var progress = '<div class="progress mb-2">';
                progress += '<div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width: 0%"></div>';
                progress += '</div>';
                $('#filemanager #msg').append(progress);

                var form_data = new FormData();

                // Read selected files
                var totalfiles = document.getElementById('files').files.length;
                for (var index = 0; index < totalfiles; index++) {
                    form_data.append("file[]", document.getElementById('files').files[index]);
                }

                $.ajax({
                    url: base_url + '/common/filemanager/upload?directory={{$directory}}',
                    type: 'post',
                    dataType: 'json',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
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
                    beforeSend: function() {
                        $('#button-upload i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                        $('#button-upload').prop('disabled', true);
                    },
                    complete: function() {
                        $('#button-upload i').replaceWith('<i class="fas fa-upload"></i>');
                        $('#button-upload').prop('disabled', false);
                    },
                    success: function(json) {
                        $('#filemanager #msg').html(json);
                        if (json['error']) {
                            $.notify(json['error'], {
                                'type':'danger'
                            });
                            return false;
                        }
                        if (json['success']) {
                            $.notify(json['success']);
                            $('#button_refresh').trigger('click');
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    });

    $('#button_folder').on('click', function (e) {
        var button_folder = $(this);
        var $popover = button_folder.data('bs.popover');

        e.preventDefault();

        $('#button-folder').popover('dispose');
        if ($popover) {
            is_disposing = false;
            return;
        }

        button_folder.popover({
            animation: false,
            sanitize: false,
            html: true,
            placement: 'bottom',
            customClass: 'shadow',
            trigger: 'manual',
            title: '{{$entry_folder}}',
            content: function () {
                html = '<div class="input-group">';
                html += '  <input type="text" name="folder_filemanager" value="" placeholder="{{$entry_folder}}" class="form-control">';
                html += '  <button type="button" title="{{$button_folder}}" id="button_create_folder" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i></button>';
                html += '</div>';
                return html;
            }
        });

        button_folder.popover('toggle');
        is_disposing = true;

        $('#button_create_folder').on('click', function() {
            if (!$('input[name=\'folder_filemanager\']').val()) {
                $.notify('{{$error_folder_null}}', {
                    'type':'danger'
                });
                return false;
            }
            if (is_processing) {
                return false;
            }
            is_processing = true;
            $.ajax({
                url: base_url + '/common/filemanager/folder?directory={{$directory}}',
                type: 'post',
                dataType: 'json',
                data: 'folder=' + encodeURIComponent($('input[name=\'folder_filemanager\']').val()),
                beforeSend: function() {
                    $('#button_create_folder').prop('disabled', true);
                },
                complete: function() {
                    $('#button_create_folder').prop('disabled', false);
                },
                success: function(json) {
                    is_processing = false;
                    is_disposing = false;
                    if (json['error']) {
                        $.notify(json['error'], {
                            'type':'danger'
                        });
                        return false;
                    }
                    if (json['success']) {
                        $.notify(json['success']);
                        $('#button_refresh').trigger('click');
                    }
                    $('#button_folder').popover('dispose');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    is_processing = false;
                    is_disposing = false;
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    $('#button_folder').popover('dispose');
                }
            });
        });
    });

    $('#modal_image #button_delete').on('click', function(e) {
        if ( ! $('input[name^=\'path\']:checked').length) {
            $.notify('{{$error_file_null}}', {
                'type':'danger'
            });
            return false;
        }

        filemanager_dispose_all();

        $.confirm({
            title: '{{lang("Admin.text_confirm_title")}}',
            content: '{{lang("Admin.text_confirm_delete")}}',
            icon: 'fa fa-question',
            //theme: 'bootstrap',
            closeIcon: true,
            //animation: 'scale',
            typeAnimated: true,
            type: 'red',
            buttons: {
                formSubmit: {
                    text: 'Yes',
                    btnClass: 'btn-danger',
                    keys: ['y', 'enter', 'shift'],
                    action: function(){
                        if (is_processing) {
                            return false;
                        }
                        is_processing = true;

                        $.ajax({
                            url: base_url + '/common/filemanager/delete',
                            type: 'post',
                            dataType: 'json',
                            data: $('input[name^=\'path\']:checked'),
                            beforeSend: function() {
                                $('#button_delete').prop('disabled', true);
                            },
                            complete: function() {
                                $('#button_delete').prop('disabled', false);
                            },
                            success: function(json) {
                                is_processing = false;
                                if (json['error']) {
                                    $.notify(json['error'], {
                                        'type':'danger'
                                    });
                                }
                                if (json['success']) {
                                    $.notify(json['success']);
                                    $('#button_refresh').trigger('click');
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                is_processing = false;
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    }
                },
                cancel: {
                    text: 'No',
                    keys: ['n']
                },
            }
        });
    });

    $('.image-setting').on('click', function (e) {
        var image_setting = $(this);
        var $popover = image_setting.data('bs.popover');

        e.preventDefault();

        $('.image-setting').popover('dispose');
        if ($popover) {
            is_disposing = false;
            return;
        }

        image_setting.popover({
            animation: false,
            html: true,
            sanitize: false,
            placement: 'top',
            customClass: 'shadow',
            trigger: 'manual',
            content: function() {
                var html = '<a href="' + image_setting.parent().find("a.thumbnail").attr('href') + '" data-lightbox="photos" id="button_image_zoom" class="btn btn-xs btn-info"><i class="fas fa-search-plus"></i></a>';
                html += ' <button type="button" id="btn_rotation_left" class="btn btn-xs btn-secondary"><i class="fas fa-undo"></i></button>';
                html += ' <button type="button" id="btn_rotation_hor" class="btn btn-xs btn-primary"><i class="fas fa-arrows-alt-h"></i></button> <button type="button" id="btn_rotation_vrt" class="btn btn-xs btn-primary"><i class="fas fa-arrows-alt-v"></i></button>';
                html += ' <button type="button" id="btn_image_crop" onclick="Catcool.cropImage(\'' + image_setting.parent().find("input").val() + '\', 0)" class="btn btn-xs btn-warning"><i class="fas fa-crop"></i></button>';
                return html;
            }
        });

        image_setting.popover('toggle');
        is_disposing = true;

        $(document).on('click', '#button_image_zoom', function(e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });

        $('#btn_rotation_left').on('click', function (e) {
            if (is_processing) {
                return false;
            }
            is_processing = true;
            $.ajax({
                url: base_url + '/common/filemanager/rotation/90',
                type: 'POST',
                data: {
                    'path': image_setting.parent().find("input").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#btn_rotation_left i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                    $('#btn_rotation_left').prop('disabled', true);
                },
                complete: function() {
                    $('#btn_rotation_left i').replaceWith('<i class="fas fa-undo"></i>');
                    $('#btn_rotation_left').prop('disabled', false);
                },
                success: function(json) {
                    is_processing = false;
                    is_disposing = false;
                    if (json['error']) {
                        $.notify(json['error'], {
                            'type':'danger'
                        });
                    }
                    if (json['success']) {
                        image_setting.parent().find("img").attr('src', '');
                        image_setting.parent().find("img").css("background-image", "url('')");
                        image_setting.parent().find("img").attr('src', json['image']);
                        image_setting.parent().find("img").css("background-image", "url('" + json['image'] + "')").fadeIn(500);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    is_processing = false;
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    $('.image-setting').popover('dispose');
                    is_disposing = false;
                }
            });
        });

        $('#btn_rotation_hor').on('click', function (e) {
            if (is_processing) {
                return false;
            }
            is_processing = true;
            $.ajax({
                url: base_url + '/common/filemanager/rotation/hor',
                type: 'POST',
                data: {
                    'path': image_setting.parent().find("input").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#btn_rotation_hor i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                    $('#btn_rotation_hor').prop('disabled', true);
                },
                complete: function() {
                    $('#btn_rotation_hor i').replaceWith('<i class="fas fa-arrows-alt-h"></i>');
                    $('#btn_rotation_hor').prop('disabled', false);
                },
                success: function(json) {
                    is_processing = false;
                    is_disposing = false;
                    if (json['error']) {
                        $.notify(json['error'], {
                            'type':'danger'
                        });
                    }
                    if (json['success']) {
                        image_setting.parent().find("img").attr('src', '');
                        image_setting.parent().find("img").css("background-image", "url('')");
                        image_setting.parent().find("img").attr('src', json['image']);
                        image_setting.parent().find("img").css("background-image", "url('" + json['image'] + "')").fadeIn(500);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    is_processing = false;
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    $('.image-setting').popover('dispose');
                    is_disposing = false;
                }
            });
        });

        $('#btn_rotation_vrt').on('click', function (e) {
            if (is_processing) {
                return false;
            }
            is_processing = true;
            $.ajax({
                url: base_url + '/common/filemanager/rotation/vrt',
                type: 'POST',
                data: {
                    'path': image_setting.parent().find("input").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#btn_rotation_vrt i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                    $('#btn_rotation_vrt').prop('disabled', true);
                },
                complete: function() {
                    $('#btn_rotation_vrt i').replaceWith('<i class="fas fa-arrows-alt-v"></i>');
                    $('#btn_rotation_vrt').prop('disabled', false);
                },
                success: function(json) {
                    is_processing = false;
                    is_disposing = false;
                    if (json['error']) {
                        $.notify(json['error'], {
                            'type':'danger'
                        });
                    }
                    if (json['success']) {
                        image_setting.parent().find("img").attr('src', '');
                        image_setting.parent().find("img").css("background-image", "url('')");
                        image_setting.parent().find("img").attr('src', json['image']);
                        image_setting.parent().find("img").css("background-image", "url('" + json['image'] + "')").fadeIn(500);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    is_processing = false;
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    $('.image-setting').popover('dispose');
                    is_disposing = false;
                }
            });
        });

        $(document).on('click', '#btn_image_crop', function(e) {
            $('.image-setting').popover('dispose');
            is_disposing = false;
        });
    });

    function filemanager_dispose_all() {
        $(document).on('click', '#filemanager', function(e) {
            if ($(e.target).closest('.popover').length != 0 || $(e.target).closest('.image-setting').length != 0 || $(e.target).closest('#button_folder').length != 0
                || $(e.target).closest('a.thumbnail').length != 0 || $(e.target).closest('input[type=\'checkbox\']').length != 0 || $(e.target).closest('button').length != 0
                || $(e.target).closest('a').length != 0) {
                return true;
            }

            $('.image-setting').popover('dispose');
            $('#button_folder').popover('dispose');
            is_disposing = false;
            return false;
        });
    }

    $(function () {
        filemanager_dispose_all();

        $("html").on("dragover", function (e) {
            e.preventDefault();
            e.stopPropagation();
            /*$("h5").text("Drag here");*/
        });
        $("html").on("drop", function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
        $('#filemanager').on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
            /*$("h5").text("Drop");*/
        });
        $('#filemanager').on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });
        // Drop
        $('#filemanager').on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $('#form-upload').remove();
            $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /></form>');
            var file = e.originalEvent.dataTransfer.files;
            var formdata = new FormData();
            if (file.length > 0) {
                for (var i = 0; i < file.length; i++) {
                    formdata.append("file[]", file[i]);
                }
                if (typeof timer != 'undefined') {
                    clearInterval(timer);
                }
                var progress = '<div class="progress mb-2">';
                progress += '<div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width: 0%"></div>';
                progress += '</div>';
                $('#filemanager #msg').append(progress);
                timer = setInterval(function() {
                    clearInterval(timer);
                    $.ajax({
                        url: '{{site_url("common/filemanager")}}/upload?directory={{$directory}}',
                        type: 'post',
                        dataType: 'json',
                        data: formdata,
                        cache: false,
                        contentType: false,
                        processData: false,
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('#progress-bar').attr("aria-valuenow", percentComplete);
                                    $('#progress-bar').attr("style", 'width: ' + percentComplete + '%;');
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#button-upload i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                            $('#button-upload').prop('disabled', true);
                        },
                        complete: function () {
                            $('#button-upload i').replaceWith('<i class="fas fa-upload"></i>');
                            $('#button-upload').prop('disabled', false);
                        },
                        success: function (json) {
                            $('#filemanager #msg').html(json);
                            if (json['error']) {
                                $.notify(json['error'], {
                                    'type': 'danger'
                                });
                                return false;
                            }
                            if (json['success']) {
                                $.notify(json['success']);
                                $('#button_refresh').trigger('click');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('.progress').remove();
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 500);
            }
        });
    });
</script>
