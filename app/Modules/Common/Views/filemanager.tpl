{strip}
    {capture name="content_filemanager"}
        <div class="row">
            <div class="col-sm-8 col-12 mb-1">
                <a href="{$parent}" data-bs-toggle="tooltip" title="{$button_parent}" id="button_parent" class="btn btn-sm btn-light btn-space"><i class="fas fa-level-up-alt"></i></a>
                <a href="{$display_url}&d={DISPLAY_GRID}" data-bs-toggle="tooltip" title="{lang("Admin.text_grid")}" id="button_display_grid" class="btn btn-sm btn-outline-light btn-space"><i class="fas fa-th"></i></a>
                <a href="{$display_url}&d={DISPLAY_LIST}" data-bs-toggle="tooltip" title="{lang("Admin.text_list")}" id="button_display_list" class="btn btn-sm btn-outline-light btn-space"><i class="fas fa-list"></i></a>
                <a href="{$refresh}" data-bs-toggle="tooltip" title="{$button_refresh}" id="button_refresh" class="btn btn-sm btn-secondary btn-space"><i class="fas fa-sync"></i></a>
                <button type="button" data-bs-toggle="tooltip" title="{$button_upload}" id="button-upload" class="btn btn-sm btn-primary btn-space"><i class="fas fa-upload me-1"></i>{$button_upload}</button>
                <button type="button" title="{$button_folder}" id="button_folder" class="btn btn-sm btn-success btn-space"><i class="fas fa-folder me-1"></i>{$button_folder}</button>
                <button type="button" data-bs-toggle="tooltip" title="{$button_delete}" id="button_delete" class="btn btn-sm btn-danger btn-space"><i class="fas fa-trash"></i></button>
            </div>
            <div class="col-sm-4 col-12 mb-1">
                <div class="input-group">
                    <input type="text" name="search" value="{$filter_name}" placeholder="{$entry_search}" style="min-width: 50px;" class="form-control btn-space me-0">
                    <button type="button" title="{$button_search}" id="button_search" class="btn btn-sm btn-primary btn-space"><i class="fas fa-search"></i></button>
                    <a href="{base_url('image/editor')}" data-bs-toggle="tooltip" title="Photo Editor" target="_blank" class="btn btn-sm btn-warning btn-space me-0"><i class="fas fa-pencil-alt"></i></a>
                </div>
            </div>
        </div>
        <div>{lang('Admin.text_upload_drop_drap')}</div>
        <hr />
        <div id="msg" class="text-secondary"></div>
        <div class="row" id="filemanager_list">
            {if $display == DISPLAY_LIST}
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered second">
                        <thead>
                            <tr class="text-center">
                                <th colspan="3">{lang('Admin.text_name')}</th>
                                <th width="110">
                                    {lang('FileManager.text_size')}
                                </th>
                                <th width="170">{lang('FileManager.text_mtime')}</th>
                            </tr>
                        </thead>
                        <tbody>
                        {foreach $file_list as $key => $file}
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="path[]" value="{$file.path}" id="cb_{$key}" class="me-1" />
                                </td>
                                <td class="text-center">
                                    {if $file.type == 'directory'}
                                        <a href="{$file.href}" class="directory" style="vertical-align: middle;"><i class="fas fa-folder fa-4x"></i></a>
                                    {elseif $file.type == 'image'}
                                        <div class="img-photo-list position-relative">
                                            <img src="{image_thumb_url($file.path, 180, 180)}" style="background-image: url('{image_thumb_url($file.path, 180, 180)}');" alt="{$file.name}" title="{$file.name}" class="img-blur" />
                                            <a href="{$file.thumb}" target="_blank" {if empty($target) && !empty($is_show_lightbox)}data-lightbox="photos"{/if} class="thumbnail" data-file-target="#cb_{$key}">
                                                <img src="{image_thumb_url($file.path, 180, 180)}" style="background-image: url('{image_thumb_url($file.path, 180, 180)}');" alt="{$file.name}" title="{$file.name}" class="" />
                                            </a>
                                            <button type="button" class="btn btn-xs btn-light image-setting shadow-sm" data-path="{$file.path}" data-bs-toggle="popover"><i class="fas fa-ellipsis-h"></i></button>
                                        </div>
                                    {elseif $file.type == 'video'}
                                        <div class="position-relative">
                                            <a href="{$file.href}" target="_blank" class="thumbnail" data-file-target="#cb_{$key}" style="vertical-align: middle;">
                                                <video muted="muted" loop="loop" style="width: 100%; max-width: 120px; height: 100%;">
                                                    <source src="{$file.href}" type="{$file.ext}">
                                                    <p>Your browser doesn't support HTML5 video. Here is
                                                        a link to the video instead.</p>
                                                </video>
                                            </a>
                                            <button type="button" class="btn btn-xs btn-light video-play shadow-sm" style="right: 0; top: 0;" data-bs-toggle="modal" data-bs-target="#play_video_{$key}"><i class="fas fa-play"></i></button>
                                            <div class="modal fade video-model" id="play_video_{$key}" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="play_video_label_{$key}" >
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content shadow-lg">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="play_video_label_{$key}">{$file.name}</h5>
                                                            <button type="button" class="btn-close close-video" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <video controls height="100%" width="100%">
                                                                <source src="{$file.href}" type="{$file.ext}">
                                                                <p>Your browser doesn't support HTML5 video. Here is
                                                                    a <a href="{$file.href}">link to the video</a> instead.</p>
                                                            </video>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {else}
                                        <a href="{$file.href}" target="_blank" class="thumbnail" data-file-target="#cb_{$key}" style="vertical-align: middle;"><i class="{$file.class}"></i></a>
                                    {/if}
                                    <input type="hidden" name="path_tmp[]" id="cb_{$key}" value="{$file.path}" />
                                </td>
                                <td>
                                    <a href="{$file.href}" target="_blank" style="vertical-align: middle;">{$file.name}</a>
                                </td>
                                <td class="text-center">
                                    {if !empty($file.size)}{$file.size}{/if}
                                </td>
                                <td class="text-center">
                                    {if !empty($file.date)}{$file.date}{/if}
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            {else}
                {foreach $file_list as $key => $file}
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6 mb-3 text-center">
                        {if $file.type == 'directory'}
                            <div class="text-center"><a href="{$file.href}" class="directory" style="vertical-align: middle;"><i class="fas fa-folder fa-4x"></i></a></div>
                            <p class="mt-1">
                                <input type="checkbox" name="path[]" value="{$file.path}" id="cb_{$key}" class="me-1" />
                                <label class="file-label-cb" for="cb_{$key}">{$file.name}</label>
                            </p>
                        {elseif $file.type == 'image'}

                            <div class="img-photo-list position-relative">
                                <img src="{image_thumb_url($file.path, 180, 180)}" style="background-image: url('{image_thumb_url($file.path, 180, 180)}');" alt="{$file.name}" title="{$file.name}" class="img-blur" />
                                <a href="{$file.thumb}" target="_blank" {if empty($target) && !empty($is_show_lightbox)}data-lightbox="photos"{/if} class="thumbnail" data-file-target="#cb_{$key}">
                                    <img src="{image_thumb_url($file.path, 180, 180)}" style="background-image: url('{image_thumb_url($file.path, 180, 180)}');" alt="{$file.name}" title="{$file.name}" class="" />
                                </a>
                                <button type="button" class="btn btn-xs btn-light image-setting shadow-sm" data-path="{$file.path}" data-bs-toggle="popover"><i class="fas fa-ellipsis-h"></i></button>
                            </div>

                            <div class="row mt-1">
                                <div class="col-12">
                                    <input type="checkbox" name="path[]" value="{$file.path}" id="cb_{$key}" class="me-1" />
                                    <label class="file-label-cb" for="cb_{$key}" title="{$file.name}">
                                        {if strlen($file.name) > 30}
                                            {substr_replace($file.name, "...", 5, strlen($file.name) - 15)}
                                        {else}
                                            {$file.name}
                                        {/if}
                                    </label>
                                </div>
                            </div>

                        {elseif $file.type == 'video'}
                            <div class="w-100 position-relative">
                                <a href="{$file.href}" target="_blank" class="thumbnail" title="{$file.name}" data-file-target="#cb_{$key}" style="vertical-align: middle;">
                                    <video style="width: 100%; max-width: 200px; height: auto;" muted="muted" loop="loop">
                                        <source src="{$file.href}" type="{$file.ext}">
                                        <p>Your browser doesn't support HTML5 video. Here is
                                            a link to the video instead.</p>
                                    </video>
                                </a>
                                <button type="button" class="btn btn-xs btn-light video-play shadow-sm" data-bs-toggle="modal" data-bs-target="#play_video_{$key}"><i class="fas fa-play"></i></button>
                            </div>
    {*                            <object width="90" height="60">*}
    {*                                <param name="src" value="{$file.href}">*}
    {*                                <param name="autoplay" value="false">*}
    {*                                <param name="controller" value="true">*}
    {*                                <param name="bgcolor" value="#333333">*}
    {*                                <embed type="{$file.ext}" src="{$file.href}" autostart="false" loop="false" width="90" height="60" controller="true" bgcolor="#333333"></embed>*}
    {*                            </object>*}
                            <!-- Modal -->
                            <div class="modal fade video-model" id="play_video_{$key}" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="play_video_label_{$key}" >
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content shadow-lg">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="play_video_label_{$key}">{$file.name}</h5>
                                            <button type="button" class="btn-close close-video" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <video controls height="100%" width="100%" >
                                                <source src="{$file.href}" type="{$file.ext}">
                                                <p>Your browser doesn't support HTML5 video. Here is
                                                    a <a href="{$file.href}">link to the video</a> instead.</p>
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-1">
                                <input type="checkbox" name="path[]" value="{$file.path}" id="cb_{$key}" class="me-1" />
                                <label class="file-label-cb" for="cb_{$key}" title="{$file.name}">
                                    {if strlen($file.name) > 30}
                                        {substr_replace($file.name, "...", 5, strlen($file.name) - 15)}
                                    {else}
                                        {$file.name}
                                    {/if}
                                </label>
                            </p>
                        {else}
                            <a href="{$file.href}" target="_blank" class="thumbnail" data-file-target="#cb_{$key}" title="{$file.name}" style="vertical-align: middle;"><i class="{$file.class}"></i></a>
                            <p class="mt-1">
                                <input type="checkbox" name="path[]" value="{$file.path}" id="cb_{$key}" class="me-1" />
                                <label class="file-label-cb" for="cb_{$key}" title="{$file.name}">
                                    {if strlen($file.name) > 30}
                                        {substr_replace($file.name, "...", 5, strlen($file.name) - 15)}
                                    {else}
                                        {$file.name}
                                    {/if}
                                </label>
                            </p>
                        {/if}
                    </div>
                {/foreach}
            {/if}
        </div>
    {/capture}
    <div id="filemanager" class="modal-dialog modal-xl px-4" style="max-width: 100% !important;">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="photoModalLabel">{$heading_title}{if !empty($directory)} ({$directory|urldecode}){/if}</h5>
                <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="min-height: 600px;">
                {$smarty.capture.content_filemanager}
            </div>
            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-sm-9">
                        <nav aria-label="Page navigation" class="table-responsive text-center"><ul class="pagination p-0 m-0">{$pagination}</ul></nav>
                    </div>
                    <div class="col-12 col-sm-3 text-end"><a id="mgr_delete_cache" href="javascript:void(0)">{lang('FileManager.text_clear_cache')}</a></div>
                </div>
            </div>
        </div>
    </div>
{/strip}

{if $thumb}{form_hidden('file_thumb', $thumb)}{/if}
{if $target}{form_hidden('file_target', $target)}{/if}
{if $file_type}{form_hidden('file_type', $file_type)}{/if}

<script type="text/javascript">
    var is_processing = false;
    var is_disposing = false;

    if ($('input[name=\'file_target\']').length) {
        $('a.thumbnail').on('click', function (e) {
            e.preventDefault();
            if ($('input[name=\'file_thumb\']').length) {
                $('#' + $('input[name=\'file_thumb\']').val()).attr('src', $(this).find('img').attr('src'));
            }
            $('#' + $('input[name=\'file_target\']').val()).val($($(this).data('file-target')).val());
            $('#modal_image').modal('hide');
        });
    }

    $('a.directory').on('click', function(e) {
        $('.image-setting').popover('dispose');
        $('#button_folder').popover('dispose');
        is_disposing = false;

        e.preventDefault();
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
        $('#modal_image').load($(this).attr('href'));
        return false;
    });
    $('.pagination a').on('click', function(e) {
        $('.image-setting').popover('dispose');
        $('#button_folder').popover('dispose');
        is_disposing = false;

        e.preventDefault();
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
        $('#modal_image').load($(this).attr('href'));
        return false;
    });
    $('#button_parent').on('click', function(e) {
        $('.image-setting').popover('dispose');
        $('#button_folder').popover('dispose');
        $('[data-bs-toggle=\'tooltip\']').tooltip('dispose');
        is_disposing = false;

        e.preventDefault();
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
        $('#modal_image').load($(this).attr('href'));
        return false;
    });
    $('#button_display_grid').on('click', function(e) {
        $('.image-setting').popover('dispose');
        $('#button_folder').popover('dispose');
        $('[data-bs-toggle=\'tooltip\']').tooltip('dispose');
        is_disposing = false;

        e.preventDefault();
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
        $('#modal_image').load($(this).attr('href'));
        return false;
    });
    $('#button_display_list').on('click', function(e) {
        $('.image-setting').popover('dispose');
        $('#button_folder').popover('dispose');
        $('[data-bs-toggle=\'tooltip\']').tooltip('dispose');
        is_disposing = false;

        e.preventDefault();
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
        $('#modal_image').load($(this).attr('href'));
        return false;
    });
    $('#button_refresh').on('click', function(e) {
        if (is_processing) {
            return false;
        }
        is_processing = true;

        $('.image-setting').popover('dispose');
        $('#button_folder').popover('dispose');
        $('[data-bs-toggle=\'tooltip\']').tooltip('dispose');
        is_disposing = false;

        e.preventDefault();
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
        $('#modal_image').load($(this).attr('href'));
        return false;
    });
    $('#filemanager #mgr_delete_cache').on('click', function(e) {
        is_processing = true;
        e.preventDefault();
        $.ajax({
            url: base_url + '/common/filemanager/clear_cache',
            type: 'POST',
            dataType: 'json',
            success: function(json) {
                is_processing = false;
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
                is_processing = false;
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
        return false;
    });
    $('input[name=\'search\']').on('keydown', function(e) {
        if (e.which == 13) {
            $('#button_search').trigger('click');
        }
    });

    $('#button_search').on('click', function(e) {
        $('.image-setting').popover('dispose');
        $('#button_folder').popover('dispose');
        is_disposing = false;

        var url = base_url + '/common/filemanager?directory={{$directory}}&d={{$display}}';
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
        if ($('input[name=\'file_type\']').length) {
            url += '&type=' + $('input[name=\'file_type\']').val();
        }

        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
        $('#modal_image').load(url);
    });

    $('#button-upload').on('click', function() {
        filemanager_dispose_all();

        $('[data-bs-toggle=\'tooltip\']').tooltip('dispose');

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
                    url: base_url + '/common/filemanager/upload?directory={{$directory}}&type={{$file_type}}',
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

        $('[data-bs-toggle=\'tooltip\']').tooltip('dispose');

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

        var path_url = $(this).data('path');

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
                html += ' <button type="button" id="btn_image_crop" onclick="Catcool.cropImage(\'' + path_url + '\', 0)" class="btn btn-xs btn-warning"><i class="fas fa-crop"></i></button>';
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
                    'path': path_url
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
                    'path': path_url
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
                    'path': path_url
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
            // if ($(e.target).closest('.popover').length != 0 || $(e.target).closest('.image-setting').length != 0 || $(e.target).closest('#button_folder').length != 0
            //     || $(e.target).closest('a.thumbnail').length != 0 || $(e.target).closest('input[type=\'checkbox\']').length != 0 || $(e.target).closest('button').length != 0
            //     || $(e.target).closest('a').length != 0 || $(e.target).closest('.file-label-cb').length != 0) {
            //     return true;
            // }

            if ($(e.target).closest('.popover').length != 0 || $(e.target).closest('.image-setting').length != 0 || $(e.target).closest('#button_folder').length != 0
                || $(e.target).closest('.btn-close').length != 0
            ) {
                return true;
            }

            if ($('.image-setting').data('bs-toggle') == 'popover') {
                $('.image-setting').popover('dispose');
            }

            $('#button_folder').popover('dispose');

            is_disposing = false;
            return;
        });
    }

    $(function () {
        filemanager_dispose_all();

        $('.loading').remove().fadeOut();

        if ($('[data-bs-toggle=\'tooltip\']').length) {
            $('[data-bs-toggle=\'tooltip\']').tooltip('dispose');
            $('[data-bs-toggle=\'tooltip\']').tooltip();
        }

        $(document).on("click", "button.close-video", function (e) {
            $('.video-model').modal('hide');
            $('.video-model video').get(0).pause();
            $('body').addClass('modal-open');
        });
        $(document).on('hidden.bs.modal', '.video-model', function (e) {
            $('.video-model').modal('hide');
            $(this).find('video').get(0).pause();
            $('body').addClass('modal-open');
        });
        $(document).on("click", ".video-play", function (e) {
            $($(this).data("bs-target")).find('video').get(0).play();
        });

        $("html").on("dragover", function (e) {
            e.preventDefault();
            e.stopPropagation();
            /*$("h5").text("Drag here");*/
            $('#modal_image .modal-body').removeClass('upload-drop');
        });
        $("html").on("drop", function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
        $('#filemanager').on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $('#modal_image .modal-body').addClass('upload-drop');
        });
        $('#filemanager').on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $('#modal_image .modal-body').addClass('upload-drop');
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
                        url: '{{site_url("common/filemanager")}}/upload?directory={{$directory}}&type={{$file_type}}',
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
                            $('#button-upload i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
                            $('#button-upload').prop('disabled', true);
                        },
                        complete: function () {
                            $('#button-upload i').replaceWith('<i class="fas fa-upload me-1"></i>');
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
