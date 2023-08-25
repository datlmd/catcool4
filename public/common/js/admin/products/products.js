var is_product_processing = false;
var timeout_variant;

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

$(document).on('click', '#product_add_variant', function() {
    var product_variant_option_row = $('#product_variant_option_row').val();
    var product_variant_option_value_row = $('#product_variant_option_value_row').val();

    $('#product_add_variant').hide();
    $('#product_variant_option').fadeIn();

    for(i = 1; i <= product_variant_option_row; i++) {
        console.log('#product_variant_option_row_' + i + ' .product-variant-option-listproduct-variant-option-list ul');
        Sortable.create($('#product_variant_option_row_' + i + ' .product-variant-option-list ul')[0], {
            animation: 100,
            onSort: function (evt) {
                // same properties as onEnd
                //alert(335);
            },
        });
    }

    showListOptionVariant();
});

$(document).on('click', '#product_variant_option .btn-variant-option-add', function() {
    var product_variant_option_row = $('#product_variant_option_row').val();
    var product_variant_option_value_row = $('#product_variant_option_value_row').val();

    product_variant_option_value_row = parseInt(product_variant_option_value_row) + 1;
    $('#product_variant_option_value_row').val(product_variant_option_value_row);

    var html = $('#html_product_variant_option_form').html().replaceAll('product_variant_option_row_value', product_variant_option_row).replaceAll('product_variant_option_value_row_value', product_variant_option_value_row);

    $(this).parent().find('ul').append('<li class="list-group-item">' + html + '</li>');
});

$(document).on('click mousemove', '#product_variant_option .product-variant-option-list ul li', function() {
    clearTimeout(timeout_variant);
    timeout_iconpicker = setTimeout(function () {
        showListOptionVariant();
    }, 1000);
});

$(document).on('keypress', '#product_variant_option .variant-option-name', function() {
    if ($(this).val().length) {
        $(this).parent().find('.variant-option-name-length').html($(this).val().length);
    } else {
        $(this).parent().find('.variant-option-name-length').html(0);
    }

    clearTimeout(timeout_variant);
    timeout_iconpicker = setTimeout(function () {
        showListOptionVariant();
    }, 1000);
});

$(document).on('change', '#product_variant_option select', function() {
    showListOptionVariant();
});

function showListOptionVariant() {
    var product_variant_option_row = $('#product_variant_option_row').val();
    var product_variant_option_value_row = $('#product_variant_option_value_row').val();

    var html_option_header = "";

    $('#product_variant_option select').each(function(i) {
        if ($(this).val() && $(this).val() != "") {
            html_option_header += '<td class="variant-name">' + $(this).find('option:selected').text() + '</td>';
        } else {
            html_option_header += '<td class="variant-name">' + $('#product_variant_option_info table thead tr').data('variant') + (i+1) + '</td>';
        }
    });
    // if ($('#product_variant_option_row_1').length) {
    //     if ($('#input_product_variant_1_option_id').val() && $('#input_product_variant_1_option_id').val() != "") {
    //         html_option_header += '<td class="variant-name">' + $('#input_product_variant_1_option_id option:selected').text() + '</td>';
    //     } else {
    //         html_option_header += '<td class="variant-name">' + $('#product_variant_option_info table thead tr').data('variant') + '</td>';
    //     }
    // }
    //
    // if ($('#product_variant_option_row_2').length) {
    //     if ($('#input_product_variant_2_option_id').val() && $('#input_product_variant_2_option_id').val() != "") {
    //         html_option_header += '<td class="variant-name">' + $('#input_product_variant_2_option_id option:selected').text() + '</td>';
    //     } else {
    //         html_option_header += '<td class="variant-name">' + $('#product_variant_option_info table thead tr').data('variant') + '</td>';
    //     }
    // }

    html_option_header += '<td>' + $('#product_variant_option_info table thead tr').data('price') + '</td>';
    html_option_header += '<td>' + $('#product_variant_option_info table thead tr').data('quantity') + '</td>';
    html_option_header += '<td>' + $('#product_variant_option_info table thead tr').data('sku') + '</td>';

    $('#product_variant_option_info table thead tr').html(html_option_header);

    //var html_template_input = '<td><input type="text" name="product_variant[{$product_variant_option_row}][option_values][{$product_variant_option_value_row}]" value="" id="input_price" class="form-control"></td>';
    // $('#product_variant_option select').each(function(i) {
    //
    // });
    //for(i = 1; i < product_variant_option_row; i++) {
    var html_option_tr = "";
    var option_list = $('.product-variant-option');
    //option_list.each(function(index, el) {
    if (option_list.eq(2).length) {

    } else if (option_list.eq(1).length) {

    } else {
        $('#product_variant_option_row_' + option_list.eq(0).data('row') + ' .variant-option-name.default').each(function() {
            var variant_option_info_row_id = 'variant_option_info_row_' + $(this).data('variant-option-value-row');
            html_option_tr += '<tr id="variant_option_info_row' + variant_option_info_row_id + '">';
            html_option_tr += '<td class="variant-name">' + $(this).val() + '</td>';


            html_option_tr += '<td id="' + variant_option_info_row_id + '_price"><input type="text" name="product_variant[{$product_variant_option_row}][option_values][{$product_variant_option_value_row}]" value="' + $('#' + variant_option_info_row_id + '_price input').val() + '" id="input_price" class="form-control"></td>';
            html_option_tr += '<td id="' + variant_option_info_row_id + '_quantity"><input type="text" name="product_variant[{$product_variant_option_row}][option_values][{$product_variant_option_value_row}]" value="' + $('#' + variant_option_info_row_id + '_quantity input').val() + '" id="input_price" class="form-control"></td>';
            html_option_tr += '<td id="' + variant_option_info_row_id + '_sku"><input type="text" name="product_variant[{$product_variant_option_row}][option_values][{$product_variant_option_value_row}]" value="' + $('#' + variant_option_info_row_id + '_sku input').val() + '" id="input_price" class="form-control"></td>';

            html_option_tr += '</tr>';
        });
    }

    if (html_option_tr != "") {
        $('#product_variant_option_info table tbody').html(html_option_tr);
    }

    //});


    //getItemOptionVariant(0, option_list)
    // option_list.each(function(index, el) {
    //         console.log(option_list[index]);
    //     console.log();
    //     });
    //}
}


function setInputItemOptionVariant(index, option_list) {

}

function getItemOptionVariant(index, option_list) {
    var html = '<tr>';

    if (index !== option_list.length - 1) {
        return '';
    }
    return getItemOptionVariant(index+1, option_list);
}
