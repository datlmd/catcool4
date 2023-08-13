var is_product_processing = false;

$(function () {
    Tiny_content.loadTiny(500);

    // preventing page from redirecting
    $("html .drop-drap-file").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('.upload-area h5').removeClass('upload-drop');
        console.log(1);
    });

    $("html .drop-drap-file").on("drop", function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log(2);
    });

    // Drag enter .upload-area
    $('body .drop-drap-file').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $('.upload-area h5').removeClass('upload-drop');
        console.log(3);
    });

    // Drag over class .upload-area
    $('body .drop-drap-file').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $('.upload-area h5').addClass('upload-drop');
        console.log(4);
    });

    // Drop
    $('body .drop-drap-file').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        //$("h5").text("Upload");
        var file = e.originalEvent.dataTransfer.files;
        var fd = new FormData();

        if (file.length > 0) {
            for (var i = 0; i < file.length; i++) {
                fd.append("files[]", file[i]);
            }

            uploadData(fd);
        }

        //uploadData(fd);
    });

    // Open file selector on div click
    $(document).on('click', ".drop-drap-file .upload-area", function(obj) {
        $("#file").click();
    });

    // file selected
    $(document).on('change', ".drop-drap-file #file", function(obj) {
        var fd = new FormData();

        //var files = $('#file')[0].files[0];

        var files = $(this);
        for (var i = 0; i < this.files.length; i++) {
            fd.append("files[]", files[0].files[i]);
        }

        //fd.append('file',files);

        uploadData(fd);
    });

});

function addProductImage()
{
    var product_image_row = $('#product_image_row').val();
    product_image_row = parseInt(product_image_row) + 1;
    $('#product_image_row').val(product_image_row);

    var html = $('#html_product_image').html().replaceAll('product_image_row_value', product_image_row);
    $('#product_image_thumb_list').append('<li class="photo-item">' + html + '</li>');
}

function addProductAttribute()
{
    var product_attribute_row = $('#product_attribute_row').data('value');
    product_attribute_row = parseInt(product_attribute_row) + 1;
    $('#product_attribute_row').data('value', product_attribute_row);

    var html = $('#html_product_attribute_row table tbody').html().replaceAll('product_attribute_row_value', product_attribute_row);
    $('#product_attribute_list tbody').append(html);
}

// Sending AJAX request and upload file
function uploadData(formdata) {
    if (is_product_processing) {
        return false;
    }
    var module_name = $('.drop-drap-file').attr("data-module");
    if (!module_name.length) {
        return false;
    }

    formdata.append('module',module_name);

    var progress = '<div class="progress">';
    progress += '<div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width: 0%"></div>';
    progress += '</div>';
    $('.drop-drap-file').append(progress);

    $('.loading').fadeIn();

    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }

    timer = setInterval(function() {
        clearInterval(timer);
        $('#image_error').fadeOut();
        is_product_processing = true;
        $.ajax({
            url: 'image/upload',
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
            success: function(data) {
                is_product_processing = false;
                $('.loading').fadeOut();
                $('.drop-drap-file .progress').remove().fadeOut();
                $('.upload-area h5').removeClass('upload-drop');

                // var response = JSON.stringify(data);
                // response     = JSON.parse(response);
                if (data['status'] == 'ng') {
                    $.notify(data['msg'], {'type': 'danger'});
                    if ($('#image_error').length) {
                        $('#image_error').html(data['msg']);
                        $('#image_error').fadeIn();
                    }
                    return false;
                }
                addThumbnail(data);
            },
            error: function (xhr, errorType, error) {
                is_product_processing = false;
                $('.loading').fadeOut();
                $('.drop-drap-file .progress').remove().fadeOut();
                $('.upload-area h5').removeClass('upload-drop');
            }
        });
    }, 500);
}

// Added thumbnail
function addThumbnail(data) {
    var product_image_row = $('#product_image_row').val();
    product_image_row = parseInt(product_image_row) + 1;

    var image_html = "";
    for (key in data) {
        image_html += '<li class="photo-item">';
        image_html += '    <input type="hidden" name="product_image[' + product_image_row + '][product_image_id]" value="" />';
        image_html += '    <a href="" data-lightbox="products"><img src="" class="img-backgroud" style="background-image: url(' + image_url + '/' + data[key]['image_url'] + ')" alt="" title="" id="product_image_' + product_image_row + '_load_image_url" /></a>';
        image_html += '    <div class="btn-group w-100 mt-1" role="group">';
        image_html += '        <button type="button" id="button-image-crop" class="btn btn-xs btn-light" onclick="Catcool.cropImage(\'' + data[key]['image_url'] +'\', 1, this);"><i class="fas fa-crop"></i></button>';
        image_html += '        <button type="button" id="button-image-delete" onclick="$(this).parent().parent().remove();" class="btn btn-xs btn-light"><i class="fas fa-trash"></i></button>';
        image_html += '    </div>';
        image_html += '    <input type="hidden" name="product_image[' + product_image_row + '][image]" value="' + data[key]['image_url'] + '" id="input_product_image_' + product_image_row + '_image" />';
        image_html += '</li>';

        product_image_row = parseInt(product_image_row) + 1;
    }

    $('#product_image_row').val(product_image_row);
    $('#product_image_thumb_list').append(image_html);
}
