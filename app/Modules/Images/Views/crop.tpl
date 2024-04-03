{strip}
    <div id="modal_image_crop" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
        <div id="crop_manager" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">{lang('Image.text_crop_image')}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 pt-3 pb-2 text-center">
                    <div id="custom-preview-wrapper"></div>
                    <div class="image-wrapper" id="image-cropper-wrapper">
                        <img id="image_cropper" src="{base_url()}/file/{$image_url}?{time()}" class="w-100" style="display: none;">
                    </div>

                    <div class="btn-group float-end mt-1" role="group">
                        <button type="button" id="btn_form_crop_rotation_left" class="btn btn-sm btn-light"><i class="fas fa-undo"></i></button>
                        <button type="button" id="btn_form_crop_rotation_hor" class="btn btn-sm btn-light"><i class="fas fa-arrows-alt-h"></i></button>
                        <button type="button" id="btn_form_crop_rotation_vrt" class="btn btn-sm btn-light"><i class="fas fa-arrows-alt-v"></i></button>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" id="btn_submit_crop" class="btn btn-sm btn-brand btn-space" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('Image.text_crop_image')}" data-target="#filter_manage"><i class="fas fa-crop"></i> {lang('Image.text_crop_image')}</button>
                    <a href="javascript:void(0);" class="btn btn-sm btn-space btn-light" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-reply"></i> {lang('Admin.text_close')}</span>
                    </a>
                </div>
            </div>
            <input type="hidden" name="image_crop_url" id="image_crop_url" value="{$image_url}">
            <input type="hidden" name="aspect_ratio" id="aspect_ratio" value="{$aspect_ratio}">
            <input type="hidden" name="image_mime" id="image_mime" value="{$mime}">
        </div>
    </div>
{literal}
<style>
    .image-wrapper { max-width: 600px; min-width: 200px; min-height: 150px; margin: 0 auto; }
    .image-wrapper img { width: 100%; }
    #image-cropper-wrapper .rcrop-outer-wrapper { opacity: .75; }
    #image-cropper-wrapper .rcrop-outer { background: #000; }
    #image-cropper-wrapper .rcrop-croparea-inner { border: 1px dashed #fff; }
    #image-cropper-wrapper .rcrop-handler-corner { width:12px; height: 12px; background: none; border : 0 solid #51aeff; }
    #image-cropper-wrapper .rcrop-handler-top-left { border-top-width: 4px; border-left-width: 4px; top:-2px; left:-2px; }
    #image-cropper-wrapper .rcrop-handler-top-right { border-top-width: 4px; border-right-width: 4px; top:-2px; right:-2px; }
    #image-cropper-wrapper .rcrop-handler-bottom-right { border-bottom-width: 4px; border-right-width: 4px; bottom:-2px; right:-2px; }
    #image-cropper-wrapper .rcrop-handler-bottom-left { border-bottom-width: 4px; border-left-width: 4px; bottom:-2px; left:-2px; }
    #image-cropper-wrapper .rcrop-handler-border { display: none; }
    #image-cropper-wrapper .clayfy-touch-device.clayfy-handler { background: none; border : 0 solid #51aeff; border-bottom-width: 6px; border-right-width: 6px; }
</style>
{/literal}
{/strip}
<script>
    var is_processing = false;

    $(function() {
        'use strict';

        var options = {
            minSize: [100,100],
            grid: true,
            preserveAspectRatio: {{$aspect_ratio}},
            preview: {
                display: false,
                size: [100,100],
                wrapper: '#custom-preview-wrapper',
            }
        };

        setTimeout(function(){
            $('#image_cropper').show();
            $('#image_cropper').rcrop(options);

            if ($("#filemanager").length) {
                $("#modal_image_crop .btn-group").hide();
            } else {
                $("#modal_image_crop .btn-group").show();
            }

        }, 300);
    });

    $(document).on("click", '#modal_image_crop #btn_submit_crop', function(event) {
        if (is_processing) {
            return false;
        }
        is_processing = true;
        $.ajax({
            url: 'image/crop',
            type: 'POST',
            data: {
                'path': $("#image_crop_url").val(),
                'width': $("#modal_image_crop #crop_manager input[name=\'width[]\']").val(),
                'height': $("#modal_image_crop #crop_manager input[name=\'height[]\']").val(),
                'xoffset': $("#modal_image_crop #crop_manager input[name=\'x[]\']").val(),
                'yoffset': $("#modal_image_crop #crop_manager input[name=\'y[]\']").val(),
            },
            dataType: 'json',
            beforeSend: function() {
                $(this).find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                $(this).prop('disabled', true);
            },
            complete: function() {
                $(this).find('i').replaceWith('<i class="fas fa-crop"></i>');
                $(this).prop('disabled', false);
            },
            success: function(json) {
                is_processing = false;
                if (json['error']) {
                    $.notify(json['error'], {
                        'type':'danger'
                    });
                }
                if (json['success']) {
                    if ($("#filemanager").length) {
                        setTimeout(function(){
                            $('#filemanager #button_refresh').trigger('click');
                        },200);
                    } else if ($(".image-crop-target").length) {
                        $(".image-crop-target a").attr("href", image_url + '/' + json['image']);
                        $(".image-crop-target img").attr("src", image_url + '/' + json['image']);

                        if ($(".image-crop-target img.img-backgroud").length) {
                            $(".image-crop-target img").attr("style", 'background-image: url(' + image_url + '/' + json['image'] + ')');
                        }
                    }
                    $("#modal_image_crop").modal("hide");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                is_processing = false;
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
    $('#modal_image_crop').on('hidden.bs.modal', function() {
        if ($('#load_view_modal #formPhotoModal').length || $("#filemanager").length) {
            $('body').addClass('modal-open');
        }
    });

    $(document).on("click", '#modal_image_crop #btn_form_crop_rotation_left', function(e) {
        if (is_processing) {
            return false;
        }
        is_processing = true;
        $.ajax({
            url: base_url + 'common/filemanager/rotation/90',
            type: 'POST',
            data: {
                'path': $("#image_crop_url").val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#modal_image_crop #btn_form_crop_rotation_left i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
            },
            complete: function() {
                $('#modal_image_crop #btn_form_crop_rotation_left i').replaceWith('<i class="fas fa-undo"></i>');
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

                    $("#modal_image_crop #image-cropper-wrapper img").attr("src", json['image']);

                    if ($(".image-crop-target").length) {
                        $(".image-crop-target a").attr("href", json['image']);
                        $(".image-crop-target img").attr("src", json['image']);

                        if ($(".image-crop-target img.img-backgroud").length) {
                            $(".image-crop-target img").attr("style", 'background-image: url(' + json['image'] + ')');
                        }
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                is_processing = false;
                is_disposing = false;
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $(document).on("click", '#modal_image_crop #btn_form_crop_rotation_hor', function(e) {
        if (is_processing) {
            return false;
        }
        is_processing = true;
        $.ajax({
            url: base_url + '/common/filemanager/rotation/hor',
            type: 'POST',
            data: {
                'path': $("#image_crop_url").val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#modal_image_crop #btn_form_crop_rotation_hor i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
            },
            complete: function() {
                $('#modal_image_crop #btn_form_crop_rotation_hor i').replaceWith('<i class="fas fa-arrows-alt-h"></i>');
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
                    $("#modal_image_crop #image-cropper-wrapper img").attr("src", json['image']);

                    if ($(".image-crop-target").length) {
                        $(".image-crop-target a").attr("href", json['image']);
                        $(".image-crop-target img").attr("src", json['image']);

                        if ($(".image-crop-target img.img-backgroud").length) {
                            $(".image-crop-target img").attr("style", 'background-image: url(' + json['image'] + ')');
                        }
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                is_processing = false;
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                is_disposing = false;
            }
        });
    });

    $(document).on("click", '#modal_image_crop #btn_form_crop_rotation_vrt', function(e) {
        if (is_processing) {
            return false;
        }
        is_processing = true;
        $.ajax({
            url: base_url + '/common/filemanager/rotation/vrt',
            type: 'POST',
            data: {
                'path': $("#image_crop_url").val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#modal_image_crop #btn_form_crop_rotation_vrt i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
            },
            complete: function() {
                $('#modal_image_crop #btn_form_crop_rotation_vrt i').replaceWith('<i class="fas fa-arrows-alt-v"></i>');
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
                    $("#modal_image_crop #image-cropper-wrapper img").attr("src", json['image']);

                    if ($(".image-crop-target").length) {
                        $(".image-crop-target a").attr("href", json['image']);
                        $(".image-crop-target img").attr("src", json['image']);

                        if ($(".image-crop-target img.img-backgroud").length) {
                            $(".image-crop-target img").attr("style", 'background-image: url(' + json['image'] + ')');
                        }
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                is_processing = false;
                is_disposing = false;
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $(document).on('click', '#btn_image_crop', function(e) {
        $('.image-setting').popover('dispose');
        is_disposing = false;
    });

</script>
