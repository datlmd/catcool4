var is_product_processing = false;
var timeout_variant;

$(function () {
    Tiny_content.loadTiny(500);

    sortableVariantOption();

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

    $('#product_add_variant').hide();
    $('.not-variant').hide();

    showVariantOptionForm();
    $('#product_variant_option').fadeIn();

    clearTimeout(timeout_variant);
    timeout_variant = setTimeout(function() {

        sortableVariantOption();

        showListVariantSku();
    }, 300);
});

$(document).on('click', '#product_variant_option .btn-variant-option-add', function() {
    var product_variant_option_row = $(this).data('variant-option-row');
    var product_variant_option_value_row = $('#product_variant_option_value_row').val();

    product_variant_option_value_row = parseInt(product_variant_option_value_row) + 1;
    $('#product_variant_option_value_row').val(product_variant_option_value_row);

    var html = $('#html_product_variant_option_value_form').html().replaceAll('product_variant_option_row_value', product_variant_option_row).replaceAll('product_variant_option_value_row_value', product_variant_option_value_row);

    $(this).parent().find('.d-flex.flex-wrap').append('<div class="variant-option-value-item pt-3">' + html + '</div>');

    showListVariantSku();
});

function sortableVariantOption() {

    $('#product_variant_option .product-variant-option-list').each(function(i) {
        Sortable.create($(this).find('.d-flex.flex-wrap')[0], {
            animation: 100,
            onEnd: function (/**Event*/evt) {
                var itemEl = evt.item;  // dragged HTMLElement
                // console.log(evt.oldIndex);
                // console.log(evt.newIndex);
                showListVariantSku();
            },
            // onSort: function (evt) {
            //     // same properties as onEnd
            // },
        });
    });
}

function showVariantOptionForm() {
    var product_variant_option_row = $('#product_variant_option_row').val();
    var product_variant_option_value_row = $('#product_variant_option_value_row').val();

    product_variant_option_row = parseInt(product_variant_option_row) + 1;
    $('#product_variant_option_row').val(product_variant_option_row);

    product_variant_option_value_row = parseInt(product_variant_option_value_row) + 1;
    $('#product_variant_option_value_row').val(product_variant_option_value_row);

    var html = $('#html_product_variant_option_form').html().replaceAll('product_variant_option_row_value', product_variant_option_row).replaceAll('product_variant_option_value_row_value', product_variant_option_value_row);

    $('#product_variant_option .product-variant-option-group').append(html);

    // clearTimeout(timeout_variant);
    // timeout_variant = setTimeout(function() {
    //     sortableVariantOption();
    // }, 300);

    if ($('#product_variant_option #product_variant_option_row_' + product_variant_option_row + ' select').length) {
        $('#product_variant_option #product_variant_option_row_' + product_variant_option_row + ' select').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            //selectionCssClass: 'select2--small',
            //dropdownCssClass: 'select2--small',
        });
        //$(district).select2('open');
    }

    if ($('#product_variant_option .product-variant-option').length >= 3) {
        $('#product_variant_option #product_add_variant_option_group').hide();
    }
}

$(document).on('click', '#product_variant_option #product_add_variant_option_group .btn', function() {

    showVariantOptionForm();

    clearTimeout(timeout_variant);
    timeout_iconpicker = setTimeout(function () {
        showListVariantSku();

        sortableVariantOption();

        checkDisableListOption();
    }, 500);

});

$(document).on('click mousemove', '#product_variant_option .product-variant-option-list .variant-option-value-item .variant-move', function() {
    // clearTimeout(timeout_variant);
    // timeout_variant = setTimeout(function () {
    //     showListVariantSku();
    // }, 500);
});

$(document).on('click', '#product_variant_option .product-variant-option-list .variant-option-value-item .variant-delete', function() {
    $(this).parent().parent().remove();

    clearTimeout(timeout_variant);
    timeout_variant = setTimeout(function () {
        showListVariantSku();
    }, 500);
});

$(document).on('click', '#product_variant_option .product-variant-option .btn-close', function() {

    if ($('#product_variant_option .product-variant-option').length <= 3) {
        $('#product_variant_option #product_add_variant_option_group').fadeIn();
    }

    if ($('#product_variant_option .product-variant-option').length <= 1) {
        $('#product_add_variant').fadeIn();
        $('.not-variant').fadeIn();

        $('#product_variant_option').hide();
    }

    $(this).parent().parent().parent().remove();

    showListVariantSku();

    checkDisableListOption();
});

$(document).on('keyup', '#product_variant_option .variant-option-name.default', function() {
    if ($(this).val().length) {
        $(this).parent().find('.variant-option-name-length').html($(this).val().length);
    } else {
        $(this).parent().find('.variant-option-name-length').html(0);
    }

    var option_value = $(this);
    clearTimeout(timeout_variant);
    timeout_iconpicker = setTimeout(function () {
        $('td[data-option-name="row_' + option_value.data('variant-option-value-row') + '_name"]').html(option_value.val());
        //showListVariantSku();
    }, 500);
});

$(document).on('change', '#product_variant_option select', function() {
    //showListVariantSku();
    var option_data = $(this);
    $('#td_' + option_data.attr('id')).html(option_data.find('option:selected').text());

    checkDisableListOption();
});

function checkDisableListOption() {
    var option_selected = [];
    $('#product_variant_option select').each(function(index, option) {

        if ($(option).find('option:selected').val() != "") {
            option_selected[$(option).attr('id')] = $(option).find('option:selected').val();
        }

        $('#' + $(option).attr('id') + " option").prop('disabled', false);
    });

    for (key in option_selected) {
        $('#product_variant_option select').each(function (index, option) {
            //for (key in option_selected) {
            if ($(option).attr('id') == key && $(option).find('option:selected').val() == option_selected[key]) {
                return;
            }
            $('#' + $(option).attr('id') + " option[value*='" + option_selected[key] + "']").prop('disabled', true);
        });
    }
}

function showListVariantSku() {
    if (is_product_processing) {
        return;
    }
    is_product_processing = true;

    var product_variant_option_row       = $('#product_variant_option_row').val();
    var product_variant_option_value_row = $('#product_variant_option_value_row').val();

    var html_option_header = "";

    $('#product_variant_option select').each(function() {
        if ($(this).find('option:selected').val() && $(this).find('option:selected').val() != "") {
            html_option_header += '<td id="td_' + $(this).attr('id') + '" class="variant-name">' + $(this).find('option:selected').text() + '</td>';
        } else {
            html_option_header += '<td id="td_' + $(this).attr('id') + '" class="variant-name">' + $('#product_variant_option #product_variant_option_info table thead tr').data('variant') + ' ' + $(this).parent().parent().parent().data('row') + '</td>';
        }
    });

    html_option_header += '<td class="required-label">' + $('#product_variant_option #product_variant_option_info table thead tr').data('price') + '</td>';
    html_option_header += '<td class="required-label">' + $('#product_variant_option #product_variant_option_info table thead tr').data('quantity') + '</td>';
    html_option_header += '<td>' + $('#product_variant_option #product_variant_option_info table thead tr').data('sku') + '</td>';
    html_option_header += '<td>' + $('#product_variant_option #product_variant_option_info table thead tr').data('published') + '</td>';

    $('#product_variant_option #product_variant_option_info table thead tr').html(html_option_header);

    var html_option_tr             = "";
    var variant_option_info_row_id = "";
    var option_list                = $('#product_variant_option .product-variant-option');

    var variant_data_list = [];
    var return_list = [];
    var prev_options = option_list[0];
    $.each(option_list, function (index, value) {
        if (index == 0) return;
        $(this).find('.variant-option-name.default').each(function (index, value) {
            var temp_list = [];

            temp_list = $.map(prev_options, function (v, i) {
                return v + ' ' + value;
            });
            return_list = $.merge(return_list, temp_list);
        });

        return_list = $.grep(return_list, function (i) {
            return $.inArray(i, prev_options) == -1;
        });

        prev_options = return_list.slice(0);
    });

    if (option_list.eq(2).length) {
        var total_option_value_2 = parseInt($('#product_variant_option #product_variant_option_row_' + option_list.eq(1).data('row') + ' .variant-option-name.default').length);
        var total_option_value_3 = parseInt($('#product_variant_option #product_variant_option_row_' + option_list.eq(2).data('row') + ' .variant-option-name.default').length);
        $('#product_variant_option #product_variant_option_row_' + option_list.eq(0).data('row') + ' .variant-option-name.default').each(function(index_option_1, option_1) {
            $('#product_variant_option #product_variant_option_row_' + option_list.eq(1).data('row') + ' .variant-option-name.default').each(function(index_option_2, option_2) {
                $('#product_variant_option #product_variant_option_row_' + option_list.eq(2).data('row') + ' .variant-option-name.default').each(function(index_option_3, option_3) {

                    // if ($(option_1).val() == '' || $(option_1).val() === undefined || $(option_2).val() == '' || $(option_2).val() === undefined || $(option_3).val() == '' || $(option_3).val() === undefined) {
                    //     return;
                    // }

                    variant_option_info_row_id = 'variant_option_info_row_' + $(option_1).data('variant-option-value-row') + '_' + $(option_2).data('variant-option-value-row') + '_' + $(option_3).data('variant-option-value-row');

                    variant_option_name_row_1 = 'row_' + $(option_1).data('variant-option-value-row') + '_name';
                    variant_option_name_row_2 = 'row_' + $(option_2).data('variant-option-value-row') + '_name';
                    variant_option_name_row_3 = 'row_' + $(option_3).data('variant-option-value-row') + '_name';

                    html_option_tr += '<tr id="' + variant_option_info_row_id + '">';
                    if (index_option_2 == 0 && index_option_3 == 0) {
                        html_option_tr += '<td data-option-name="' + variant_option_name_row_1 + '" class="variant-name" rowspan="' + parseInt(total_option_value_2 * total_option_value_3) + '">' + $(option_1).val() + '</td>';
                    }

                    if (index_option_3 == 0) {
                        html_option_tr += '<td data-option-name="' + variant_option_name_row_2 + '" class="variant-name" rowspan="' + total_option_value_3 + '">' + $(option_2).val() + '</td>';
                    }

                    html_option_tr += '<td data-option-name="' + variant_option_name_row_3 + '" class="variant-name">' + $(option_3).val() + '</td>';
                    html_option_tr += setInputItemOptionVariant(variant_option_info_row_id);
                    html_option_tr += '</tr>';

                    if ($('#' + variant_option_info_row_id + '_price').length) {
                        variant_data_list[variant_option_info_row_id + '_price'] = $('#' + variant_option_info_row_id + '_price input').val();
                    }

                    if ($('#' + variant_option_info_row_id + '_quantity').length) {
                        variant_data_list[variant_option_info_row_id + '_quantity'] = $('#' + variant_option_info_row_id + '_quantity input').val();
                    }

                    if ($('#' + variant_option_info_row_id + '_sku').length) {
                        variant_data_list[variant_option_info_row_id + '_sku'] = $('#' + variant_option_info_row_id + '_sku input').val();
                    }

                    if ($('#' + variant_option_info_row_id + '_published').length) {
                        variant_data_list[variant_option_info_row_id + '_published'] = $('#' + variant_option_info_row_id + '_published input').prop('checked');
                    }
                });
            });
        });
    } else if (option_list.eq(1).length) {
        var total_option_value = parseInt($('#product_variant_option #product_variant_option_row_' + option_list.eq(1).data('row') + ' .variant-option-name.default').length);

        $('#product_variant_option #product_variant_option_row_' + option_list.eq(0).data('row') + ' .variant-option-name.default').each(function(index_option_1, option_1) {
            $('#product_variant_option #product_variant_option_row_' + option_list.eq(1).data('row') + ' .variant-option-name.default').each(function(index_option_2, option_2) {
                // if ($(option_1).val() == '' || $(option_1).val() === undefined || $(option_2).val() == '' || $(option_2).val() === undefined) {
                //     return;
                // }

                variant_option_info_row_id = 'variant_option_info_row_' + $(option_1).data('variant-option-value-row') + '_' + $(option_2).data('variant-option-value-row');

                variant_option_name_row_1 = 'row_' + $(option_1).data('variant-option-value-row') + '_name';
                variant_option_name_row_2 = 'row_' + $(option_2).data('variant-option-value-row') + '_name';

                html_option_tr += '<tr id="' + variant_option_info_row_id + '">';
                if (index_option_2 === 0) {
                    html_option_tr += '<td data-option-name="' + variant_option_name_row_1 + '" class="variant-name" rowspan="' + total_option_value + '">' + $(option_1).val() + '</td>';
                }
                html_option_tr += '<td data-option-name="' + variant_option_name_row_2 + '" class="variant-name">' + $(option_2).val() + '</td>';

                html_option_tr += setInputItemOptionVariant(variant_option_info_row_id);
                html_option_tr += '</tr>';

                if ($('#' + variant_option_info_row_id + '_price').length) {
                    variant_data_list[variant_option_info_row_id + '_price'] = $('#' + variant_option_info_row_id + '_price input').val();
                }

                if ($('#' + variant_option_info_row_id + '_quantity').length) {
                    variant_data_list[variant_option_info_row_id + '_quantity'] = $('#' + variant_option_info_row_id + '_quantity input').val();
                }

                if ($('#' + variant_option_info_row_id + '_sku').length) {
                    variant_data_list[variant_option_info_row_id + '_sku'] = $('#' + variant_option_info_row_id + '_sku input').val();
                }

                if ($('#' + variant_option_info_row_id + '_published').length) {
                    variant_data_list[variant_option_info_row_id + '_published'] = $('#' + variant_option_info_row_id + '_published input').prop('checked');
                }
            });
        });

    } else {

        $('#product_variant_option #product_variant_option_row_' + option_list.eq(0).data('row') + ' .variant-option-name.default').each(function() {
            // if ($(this).val() == '' || $(this).val() === undefined) {
            //     return;
            // }
            variant_option_info_row_id = 'variant_option_info_row_' + $(this).data('variant-option-value-row');

            variant_option_name_row    = 'row_' + $(this).data('variant-option-value-row') + '_name';

            html_option_tr += '<tr id="' + variant_option_info_row_id + '">';
            html_option_tr += '<td data-option-name="' + variant_option_name_row + '" class="variant-name">' + $(this).val() + '</td>';
            html_option_tr += setInputItemOptionVariant(variant_option_info_row_id);
            html_option_tr += '</tr>';

            if ($('#' + variant_option_info_row_id + '_price').length) {
                variant_data_list[variant_option_info_row_id + '_price'] = $('#' + variant_option_info_row_id + '_price input').val();
            }

            if ($('#' + variant_option_info_row_id + '_quantity').length) {
                variant_data_list[variant_option_info_row_id + '_quantity'] = $('#' + variant_option_info_row_id + '_quantity input').val();
            }

            if ($('#' + variant_option_info_row_id + '_sku').length) {
                variant_data_list[variant_option_info_row_id + '_sku'] = $('#' + variant_option_info_row_id + '_sku input').val();
            }

            if ($('#' + variant_option_info_row_id + '_published').length) {
                variant_data_list[variant_option_info_row_id + '_published'] = $('#' + variant_option_info_row_id + '_published input').prop('checked');
            }

        });
    }

    //if (html_option_tr != "") {
        $('#product_variant_option #product_variant_option_info table tbody').html(html_option_tr).fadeIn();
    //}
    // else {
    //     $('#product_variant_option #product_variant_option_info table tbody').html('<tr><td>Không có SKU nào sẵn có</td></tr>');
    // }

    for (key in variant_data_list) {
        if (key.includes('published')) {

            $('#' + key + ' input').prop('checked', variant_data_list[key]);
        } else {
            $('#' + key + ' input').val(variant_data_list[key]);
        }
    }

    is_product_processing = false;
}


function setInputItemOptionVariant(option_info_row_id)
{

    var htm_td = $('#html_product_variant_option_value_form_td table tr').html();

    htm_td = htm_td.replaceAll('__option_info_row_id__', option_info_row_id).replaceAll('data-id', 'id');

    return htm_td;
}
