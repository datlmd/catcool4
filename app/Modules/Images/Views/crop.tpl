<div id="modal_image_crop" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
    <div id="crop_manager" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">{lang('text_crop_image')}</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body px-3 py-4 text-center">
                <div id="custom-preview-wrapper"></div>
                <div class="image-wrapper" id="image-cropper-wrapper">
                    <img id="image_cropper" src="{image_url($image_url)}?{time()}" class="w-100" style="display: none;">
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" id="btn_submit_crop" class="btn btn-sm btn-brand btn-space" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('text_crop_image')}" data-target="#filter_manage"><i class="fas fa-crop"></i> {lang('text_crop_image')}</button>
                <a href="javascript:void(0);" class="btn btn-sm btn-space btn-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-reply"></i> {lang('text_close')}</span>
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
<script>

    var is_processing = false;

    $(document).ready(function(){
        'use strict';
        setTimeout(function(){
            $('#image_cropper').show();
            $('#image_cropper').rcrop({
                    minSize : [100,100],
                    preserveAspectRatio : {{$aspect_ratio}},
                    preview : {
                        display: false,
                        size : [100,100],
                        wrapper : '#custom-preview-wrapper',
                    }
                }
            );
        },300);

    });

    $(document).on("click", '#btn_submit_crop', function(event) {
        if (is_processing) {
            return false;
        }
        is_processing = true;

        var srcOriginal = $('#image_cropper').rcrop('getDataURL');

        $.ajax({
            url: base_url + 'images/crop',
            type: 'POST',
            data: {
                'path': $("#image_crop_url").val(),
                'image_data': srcOriginal,
                'mime': $("#image_mime").val(),
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
                        $('#filemanager #button-refresh').trigger('click');
                    } else if ($(".image-crop-target").length) {
                        $(".image-crop-target a").attr("href", json['image']);
                        $(".image-crop-target img").attr("src", json['image']);
                    }

                    $("#modal_image_crop").modal("hide");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                is_processing = false;
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                $('.image-setting').popover('dispose');
            }
        });
    });

    $('#modal_image_crop').on('hidden.bs.modal', function() {
        if ($('#load_view_modal #formPhotoModal').length) {
            $('body').addClass('modal-open');
        }
    });
</script>