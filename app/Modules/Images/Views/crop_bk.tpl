<div id="modal_image_crop" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
    <div id="crop_manager" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">{lang('text_crop_image')}</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12 col-12">
                        <div class="img-container w-100">
                            <img id="image_cropper" src="{image_url($image_url)}?{time()}" class="w-100 cropper-hidden" alt="Picture">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-3 col-md-12 col-sm-12 col-12" id="actions">
                        <div class="mb-2">
                            <button type="button" id="btn_submit_crop" class="btn btn-sm btn-brand btn-space" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('text_crop_image')}" data-target="#filter_manage"><i class="fas fa-crop"></i> {lang('text_crop_image')}</button>
                            <a href="javascript:void(0);" class="btn btn-sm btn-space btn-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-reply"></i> {lang('text_close')}</span>
                            </a>
                        </div>

                        <!-- <h3>Preview:</h3> -->
                        <div class="docs-preview clearfix">
                            <div class="img-preview preview-lg"></div>
                            {*<div class="img-preview preview-md"></div>*}
                            {*<div class="img-preview preview-sm"></div>*}
                            {*<div class="img-preview preview-xs"></div>*}
                        </div>
                        <!-- <h3>Data:</h3> -->
                        <div class="docs-data" style="display: none;">
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataX">X</label>
                                </span>
                                <input type="text" class="form-control" id="dataX" placeholder="x">
                                <span class="input-group-append">
                                    <span class="input-group-text">px</span>
                                </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataY">Y</label>
                                </span>
                                <input type="text" class="form-control" id="dataY" placeholder="y">
                                <span class="input-group-append">
                                    <span class="input-group-text">px</span>
                                </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataWidth">Width</label>
                                </span>
                                <input type="text" class="form-control" id="dataWidth" placeholder="width">
                                <span class="input-group-append">
                                    <span class="input-group-text">px</span>
                                </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataHeight">Height</label>
                                </span>
                                <input type="text" class="form-control" id="dataHeight" placeholder="height">
                                <span class="input-group-append">
                                    <span class="input-group-text">px</span>
                                </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataRotate">Rotate</label>
                                </span>
                                <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                                <span class="input-group-append">
                                    <span class="input-group-text">deg</span>
                                </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataScaleX">ScaleX</label>
                                </span>
                                <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataScaleY">ScaleY</label>
                                </span>
                                <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                            </div>
                        </div>
                        <!-- <h3>Toggles:</h3> -->
                        <div class="docs-toggles">
                            <div class="btn-group">
                                <label class="btn btn-sm btn-primary">
                                    <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_aspect_ratio')}: 16 / 9">16:9</span>
                                </label>
                                <label class="btn btn-sm btn-primary">
                                    <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_aspect_ratio')}: 4 / 3">4:3</span>
                                </label>
                                <label class="btn btn-sm btn-primary">
                                    <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_aspect_ratio')}: 1 / 1">1:1</span>
                                </label>
                                <label class="btn btn-sm btn-primary">
                                    <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_aspect_ratio')}: 2 / 3">2:3</span>
                                </label>
                                <label class="btn btn-sm btn-primary">
                                    <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_aspect_ratio')}: Free">Free</span>
                                </label>
                            </div>
                        </div>
                        <div class="docs-buttons">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary" data-method="setDragMode" data-option="move" title="{lang('text_move')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="{lang('text_move')}">
                                        <span class="fas fa-arrows-alt"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" data-method="setDragMode" data-option="crop" title="{lang('text_crop')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="{lang('text_crop')}">
                                        <span class="fas fa-crop"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary" data-method="reset" data-toggle="tooltip" title="Reset">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Reset">
                                        <span class="fas fa-sync"></span>
                                    </span>
                                </button>
                                <label class="btn btn-sm btn-primary btn-upload m-b-0" for="inputImage" title="Upload image file">
                                    <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Upload image file">
                                        <span class="fa fa-upload"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-method="zoom" data-option="0.1" title="{lang('text_zoom_in')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_zoom_in')}">
                                        <span class="fa fa-search-plus"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" data-method="zoom" data-option="-0.1" title="{lang('text_zoom_out')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_zoom_out')}">
                                        <span class="fa fa-search-minus"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-method="move" data-option="-10" data-second-option="0" title="{lang('text_move_left')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_move_left')}">
                                        <span class="fa fa-arrow-left"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" data-method="move" data-option="10" data-second-option="0" title="{lang('text_move_right')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_move_right')}">
                                        <span class="fa fa-arrow-right"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-method="move" data-option="0" data-second-option="-10" title="{lang('text_move_up')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_move_up')}">
                                        <span class="fa fa-arrow-up"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" data-method="move" data-option="0" data-second-option="10" title="{lang('text_move_down')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_move_down')}">
                                        <span class="fa fa-arrow-down"></span>
                                    </span>
                                </button>
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-method="rotate" data-option="-45" title="{lang('text_rotate_left')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_rotate_left')}">
                                        <span class="fas fa-undo"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" data-method="rotate" data-option="45" title="{lang('text_rotate_right')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_rotate_right')}">
                                        <span class="fa fa-redo"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-method="scaleX" data-option="-1" title="{lang('text_flip_horizontal')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_flip_horizontal')}">
                                        <span class="fa fa-arrows-alt-h"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" data-method="scaleY" data-option="-1" title="{lang('text_flip_vertical')}">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_flip_vertical')}">
                                        <span class="fa fa-arrows-alt-v"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-light" data-method="moveTo" data-option="0">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_move_0')}">
                                       {lang('text_move_0')}
                                    </span>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-light" data-method="zoomTo" data-option="1">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="{lang('text_zoom_100')}">
                                        {lang('text_zoom_100')}
                                    </span>
                                </button>
                            </div>

                            <div class="btn-group btn-group-crop">
                                <button type="button" class="btn btn-sm btn-secondary" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Download Crop">
                                      Download
                                    </span>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-light" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Download 320x180">
                                      320&times;180
                                    </span>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-light" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 480, &quot;height&quot;: 270 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Download 480x270">
                                      480&times;270
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="image_crop_url" id="image_crop_url" value="{$image_url}">
        <input type="hidden" name="aspect_ratio" id="aspect_ratio" value="{$aspect_ratio}">
        <input type="hidden" name="min_container_width" id="min_container_width" value="{$min_container_width}">
        <input type="hidden" name="min_container_height" id="min_container_height" value="{$min_container_height}">
        <input type="hidden" name="image_mime" id="image_mime" value="{$mime}">
    </div>
</div>

<!-- Show the cropped image in modal -->
<div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="false" aria-labelledby="getCroppedCanvasTitle" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="getCroppedCanvasTitle">{lang('text_cropped')}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center"></div>
            <div class="modal-footer">
                <a class="btn btn-secondary" id="download" href="javascript:void(0);" download="cropped.html">Download</a>
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{lang('text_close')}</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<script>
    $('#modal_image_crop, #getCroppedCanvasModal').on('hidden.bs.modal', function() {
        $('body').addClass('modal-open');
    });

    var is_processing = false;

    $(function () {
        'use strict';

        var Cropper = window.Cropper;
        var URL = window.URL || window.webkitURL;
        var container = document.querySelector('.img-container');
        var image = container.getElementsByTagName('img').item(0);

        console.log(image);
        var download = document.getElementById('download');
        var actions = document.getElementById('actions');
        var dataX = document.getElementById('dataX');
        var dataY = document.getElementById('dataY');
        var dataHeight = document.getElementById('dataHeight');
        var dataWidth = document.getElementById('dataWidth');
        var dataRotate = document.getElementById('dataRotate');
        var dataScaleX = document.getElementById('dataScaleX');
        var dataScaleY = document.getElementById('dataScaleY');
        var options = {
            preview: '.img-preview',
            aspectRatio: $('#aspect_ratio').val(),
            minContainerWidth: $('#min_container_width').val(),
            minContainerHeight: $('#min_container_height').val(),
            autoCropArea: 0.65,
            ready: function (e) {
                //console.log(e.type);
            },
            cropstart: function (e) {
                //console.log(e.type, e.detail.action);
            },
            cropmove: function (e) {
                //console.log(e.type, e.detail.action);
            },
            cropend: function (e) {
                //console.log(e.type, e.detail.action);
            },
            crop: function (e) {
                var data = e.detail;

                //console.log(e.type);
                dataX.value = Math.round(data.x);
                dataY.value = Math.round(data.y);
                dataHeight.value = Math.round(data.height);
                dataWidth.value = Math.round(data.width);
                dataRotate.value = typeof data.rotate !== 'undefined' ? data.rotate : '';
                dataScaleX.value = typeof data.scaleX !== 'undefined' ? data.scaleX : '';
                dataScaleY.value = typeof data.scaleY !== 'undefined' ? data.scaleY : '';

                if (data.width < 100 || data.height < 80) {
                    cropper.setData({
                        width: 100,
                        height: 80,
                    });
                }
            },
            zoom: function (e) {
                //console.log(e.type, e.detail.scale);
            }
        };
        var cropper = new Cropper(image, options);
        var originalImageURL = image.src;
        var uploadedImageType = 'image/jpeg';
        var uploadedImageName = 'cropped.jpg';
        var uploadedImageURL;

        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // Buttons
        if (!document.createElement('canvas').getContext) {
            $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
        }

        if (typeof document.createElement('cropper').style.transition === 'undefined') {
            $('button[data-method="rotate"]').prop('disabled', true);
            $('button[data-method="scale"]').prop('disabled', true);
        }

        // Download
        if (typeof download.download === 'undefined') {
            download.className += ' disabled';
            download.title = 'Your browser does not support download';
        }

        // Options
        actions.querySelector('.docs-toggles').onchange = function (event) {
            var e = event || window.event;
            var target = e.target || e.srcElement;
            var cropBoxData;
            var canvasData;
            var isCheckbox;
            var isRadio;

            if (!cropper) {
                return;
            }

            if (target.tagName.toLowerCase() === 'label') {
                target = target.querySelector('input');
            }

            isCheckbox = target.type === 'checkbox';
            isRadio = target.type === 'radio';

            if (isCheckbox || isRadio) {
                if (isCheckbox) {
                    options[target.name] = target.checked;
                    cropBoxData = cropper.getCropBoxData();
                    canvasData = cropper.getCanvasData();

                    options.ready = function () {
                        console.log('ready');
                        cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                    };
                } else {
                    options[target.name] = target.value;
                    options.ready = function () {
                        console.log('ready');
                    };
                }

                // Restart
                cropper.destroy();
                cropper = new Cropper(image, options);
            }
        };

        // Methods
        actions.querySelector('.docs-buttons').onclick = function (event) {
            var e = event || window.event;
            var target = e.target || e.srcElement;
            var cropped;
            var result;
            var input;
            var data;

            if (!cropper) {
                return;
            }

            while (target !== this) {
                if (target.getAttribute('data-method')) {
                    break;
                }

                target = target.parentNode;
            }

            if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
                return;
            }

            data = {
                method: target.getAttribute('data-method'),
                target: target.getAttribute('data-target'),
                option: target.getAttribute('data-option') || undefined,
                secondOption: target.getAttribute('data-second-option') || undefined
            };

            cropped = cropper.cropped;

            if (data.method) {
                if (typeof data.target !== 'undefined') {
                    input = document.querySelector(data.target);

                    if (!target.hasAttribute('data-option') && data.target && input) {
                        try {
                            data.option = JSON.parse(input.value);
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }

                switch (data.method) {
                    case 'getCroppedCanvas':
                        try {
                            data.option = JSON.parse(data.option);
                        } catch (e) {
                            console.log(e.message);
                        }

                        if (uploadedImageType === 'image/jpeg') {
                            if (!data.option) {
                                data.option = {};
                            }

                            data.option.fillColor = '#fff';
                        }

                        break;

                    default:
                }

                result = cropper[data.method](data.option, data.secondOption);

                switch (data.method) {
                    case 'scaleX':
                    case 'scaleY':
                        target.setAttribute('data-option', -data.option);
                        break;

                    case 'getCroppedCanvas':
                        if (result) {
                            // Bootstrap's Modal
                            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

                            if (!download.disabled) {
                                download.download = uploadedImageName;
                                download.href = result.toDataURL(uploadedImageType);
                            }
                        }

                        break;

                    case 'destroy':
                        cropper = null;

                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                            uploadedImageURL = '';
                            image.src = originalImageURL;
                        }

                        break;

                    default:
                }

                if (typeof result === 'object' && result !== cropper && input) {
                    try {
                        input.value = JSON.stringify(result);
                    } catch (e) {
                        console.log(e.message);
                    }
                }
            }
        };

        document.body.onkeydown = function (event) {
            var e = event || window.event;

            if (e.target !== this || !cropper || this.scrollTop > 300) {
                return;
            }

            switch (e.keyCode) {
                case 37:
                    e.preventDefault();
                    cropper.move(-1, 0);
                    break;

                case 38:
                    e.preventDefault();
                    cropper.move(0, -1);
                    break;

                case 39:
                    e.preventDefault();
                    cropper.move(1, 0);
                    break;

                case 40:
                    e.preventDefault();
                    cropper.move(0, 1);
                    break;
            }
        };

        // Import image
        var inputImage = document.getElementById('inputImage');

        if (URL) {
            inputImage.onchange = function () {
                var files = this.files;
                var file;

                if (cropper && files && files.length) {
                    file = files[0];

                    if (/^image\/\w+/.test(file.type)) {
                        uploadedImageType = file.type;
                        uploadedImageName = file.name;

                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                        }

                        image.src = uploadedImageURL = URL.createObjectURL(file);
                        cropper.destroy();
                        cropper = new Cropper(image, options);
                        inputImage.value = null;
                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            };
        } else {
            inputImage.disabled = true;
            inputImage.parentNode.className += ' disabled';
        }

        actions.querySelector('#btn_submit_crop').onclick = function (event) {
        //$('#btn_submit_crop').click(function(e) {
            if (is_processing) {
                return false;
            }
            is_processing = true;

            var image_canvas = cropper.getCroppedCanvas().toDataURL(uploadedImageType);

            $.ajax({
                url: base_url + 'images/crop',
                type: 'POST',
                data: {
                    'path': $("#image_crop_url").val(),
                    'image_data': image_canvas,
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
                    //$('.image-setting').popover('dispose');
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
        };
    });
</script>
