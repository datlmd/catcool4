var is_product_processing = false;
var timeout_variant;
var product_variant_max = 3;
var product_variant_combination_sku_name = 'variant_info_row_'

$(function () {
    Tiny_content.loadTiny(500);

    sortableVariant();

    //Check button them bien the
    if ($('#product_variant .product-variant').length >= product_variant_max) {
        $('#product_variant #product_add_variant_group').hide();
    }

    if ($('#product_variant_combination_sku_name').length && $('#product_variant_combination_sku_name').val() != "") {
        product_variant_combination_sku_name = $('#product_variant_combination_sku_name').val();
    }

});

// preventing page from redirecting
$(document).on('dragover', ".drop-drap-image-list", function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).find('.upload-area h5').removeClass('upload-drop');
});

$(document).on('drop', ".drop-drap-image-list", function(e) {
    e.preventDefault();
    e.stopPropagation();
});

// Drag enter .upload-area
$(document).on('dragenter', ".drop-drap-image-list", function(e) {
    e.stopPropagation();
    e.preventDefault();
    $(this).find('.upload-area h5').removeClass('upload-drop');
});

// Drag over class .upload-area
$(document).on('dragover', ".drop-drap-image-list", function(e) {
    e.stopPropagation();
    e.preventDefault();
    $(this).find('.upload-area h5').addClass('upload-drop');
});

// Drop
$(document).on('drop', ".drop-drap-image-list", function(e) {
    e.stopPropagation();
    e.preventDefault();

    //$("h5").text("Upload");
    var file = e.originalEvent.dataTransfer.files;
    var fd = new FormData();

    if (file.length > 0) {
        for (var i = 0; i < file.length; i++) {
            fd.append("files[]", file[i]);
        }

        uploadDataImageList(fd);
    }

    //uploadData(fd);
});

// Open file selector on div click
$(document).on('click', ".drop-drap-image-list .upload-area", function(e) {
    e.stopPropagation();
    e.preventDefault();
    $(this).parent().find(".file-input").click();
});

// file selected
$(document).on('change', ".drop-drap-image-list .file-input", function(e) {
    var fd = new FormData();

    //var files = $('#file')[0].files[0];

    var files = $(this);
    for (var i = 0; i < this.files.length; i++) {
        fd.append("files[]", files[0].files[i]);
    }

    //fd.append('file',files);

    uploadDataImageList(fd);
});

function addProductImage()
{
    var product_image_row = $('#product_image_row').val();
    product_image_row = parseInt(product_image_row) + 1;
    $('#product_image_row').val(product_image_row);

    var html = $('#html_product_image').html().replaceAll('product_image_row_value', product_image_row);
    $('#product_image_thumb_list').append('<li id="li_product_image_row_' + product_image_row + '" class="photo-item">' + html + '</li>');

    $('#product_image_thumb_list').find('li#li_product_image_row_' + product_image_row + ' .button-image').click();
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
function uploadDataImageList(formdata) {
    if (is_product_processing) {
        return false;
    }
    var module_name = $('.drop-drap-image-list').attr("data-module");
    if (module_name == "") {
        return false;
    }

    formdata.append('module',module_name);

    var progress = '<div class="progress">';
    progress += '<div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width: 0%"></div>';
    progress += '</div>';
    $('.drop-drap-image-list').append(progress);

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
                $('.drop-drap-image-list .progress').remove().fadeOut();
                $('.drop-drap-image-list .upload-area h5').removeClass('upload-drop');

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
                addThumbnailToList(data);
            },
            error: function (xhr, errorType, error) {
                is_product_processing = false;
                $('.loading').fadeOut();
                $('.drop-drap-image-list .progress').remove().fadeOut();
                $('.drop-drap-image-list .upload-area h5').removeClass('upload-drop');
            }
        });
    }, 500);
}

// Added thumbnail
function addThumbnailToList(data) {
    var product_image_row = $('#product_image_row').val();
    product_image_row = parseInt(product_image_row) + 1;

    var image_html = "";
    for (key in data) {
        image_html += '<li class="photo-item">';
        image_html += '    <input type="hidden" name="product_image[' + product_image_row + '][product_image_id]" value="" />';
        image_html += '    <a href="' + image_url + '/' + data[key]['image_url'] + '" data-lightbox="products"><img src="" class="img-backgroud" style="background-image: url(' + image_url + "/" + data[key]['image_url'] + ')" alt="" title="" id="product_image_' + product_image_row + '_load_image_url" /></a>';
        image_html += '    <div class="btn-group w-100 mt-1" role="group">';
        image_html += '        <button type="button" id="product_image_' + product_image_row + '_image_crop" class="btn btn-xs btn-light" onclick="Catcool.cropImage(\'' + data[key]['image_url'] +'\', 1, this);"><i class="fas fa-crop"></i></button>';
        image_html += '        <button type="button" id="product_image_' + product_image_row + '_image_delete" onclick="$(this).parent().parent().remove();" class="btn btn-xs btn-light"><i class="fas fa-trash"></i></button>';
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

    showVariantForm();
    $('#product_variant').fadeIn();

    $('#is_variant').val(1);

    clearTimeout(timeout_variant);
    timeout_variant = setTimeout(function() {

        sortableVariant();

        showListVariantSku();
    }, 300);
});

$(document).on('click', '#product_variant .btn-variant-value-add', function() {
    var product_variant_row = $(this).data('variant-row');
    var product_variant_value_row = $('#product_variant_value_row').val();

    product_variant_value_row = parseInt(product_variant_value_row) + 1;
    $('#product_variant_value_row').val(product_variant_value_row);

    var html = $('#html_product_variant_value_form').html().replaceAll('product_variant_row_value', product_variant_row).replaceAll('product_variant_value_row_value', product_variant_value_row);
    if ($("#product_variant_row_" + $(this).data('variant-row')).data('is-image') === 1) {
        html = $('#html_product_variant_value_form_image').html().replaceAll('product_variant_row_value', product_variant_row).replaceAll('product_variant_value_row_value', product_variant_value_row);
    }

    $(this).parent().parent().find('.d-flex.flex-wrap').append('<div class="variant-value-item pb-3">' + html + '</div>');

    showListVariantSku();
});

function sortableVariant() {

    $('#product_variant .product-variant-list').each(function(i) {
        Sortable.create($(this).find('.d-flex.flex-wrap')[0], {
            animation: 100,
            handle: ".variant-move",
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

function showVariantForm() {
    var product_variant_row = $('#product_variant_row').val();
    var product_variant_value_row = $('#product_variant_value_row').val();

    product_variant_row = parseInt(product_variant_row) + 1;
    $('#product_variant_row').val(product_variant_row);

    product_variant_value_row = parseInt(product_variant_value_row) + 1;
    $('#product_variant_value_row').val(product_variant_value_row);

    var html = $('#html_product_variant_form').html().replaceAll('product_variant_row_value', product_variant_row).replaceAll('product_variant_value_row_value', product_variant_value_row);
    $('#product_variant .product-variant-group').append(html);

    var html_variant = "";

    if ($('#product_variant .product-variant').length === 1) {
        $("#product_variant_row_" + product_variant_row).attr('data-is-image', 1);
        $("#product_variant_row_" + product_variant_row).addClass('has-image');
        $("#product_variant_row_" + product_variant_row + " .product-variant-close button").prop("disabled", false);

        html_variant = $('#html_product_variant_value_form_image').html().replaceAll('product_variant_row_value', product_variant_row).replaceAll('product_variant_value_row_value', product_variant_value_row);
    } else {
        $("#product_variant .product-variant-group .product-variant-close button").prop("disabled", false);
        $("#product_variant .product-variant-group .product-variant.has-image .product-variant-close button").prop("disabled", true);

        html_variant = $('#html_product_variant_value_form').html().replaceAll('product_variant_row_value', product_variant_row).replaceAll('product_variant_value_row_value', product_variant_value_row);
    }
    $("#product_variant_row_" + product_variant_row).find('.d-flex.flex-wrap').append('<div class="variant-value-item pb-3">' + html_variant + '</div>');


    // clearTimeout(timeout_variant);
    // timeout_variant = setTimeout(function() {
    //   e  sortableVariant();
    // }, 300);

    if ($('#product_variant #product_variant_row_' + product_variant_row + ' select').length) {
        $('#product_variant #product_variant_row_' + product_variant_row + ' select').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            //selectionCssClass: 'select2--small',
            //dropdownCssClass: 'select2--small',
        });
        //$(district).select2('open');
    }

    if ($('#product_variant .product-variant').length >= product_variant_max) {
        $('#product_variant #product_add_variant_group').hide();
    }
}

$(document).on('click', '#product_variant #product_add_variant_group .btn', function() {

    if ($('#product_variant .product-variant').length >= product_variant_max) {
        $('#product_variant #product_add_variant_group').hide();
        return;
    }

    showVariantForm();

    clearTimeout(timeout_variant);
    timeout_iconpicker = setTimeout(function () {
        showListVariantSku();

        sortableVariant();

        checkDisableList();
    }, 500);

});

$(document).on('click mousemove', '#product_variant .product-variant-list .variant-value-item .variant-move', function() {
    // clearTimeout(timeout_variant);
    // timeout_variant = setTimeout(function () {
    //     showListVariantSku();
    // }, 500);
});

$(document).on('click', '#product_variant .product-variant-list .variant-value-item .variant-delete i', function() {
    $(this).parent().parent().parent().remove();

    clearTimeout(timeout_variant);
    timeout_variant = setTimeout(function () {
        showListVariantSku();
    }, 500);
});

$(document).on('click', '#product_variant .product-variant .btn-close', function() {

    if ($('#product_variant .product-variant').length > 1 && $(this).parent().parent().parent().data('is_image') == 1) {
        return false;
    }

    if ($('#product_variant .product-variant').length <= product_variant_max) {
        $('#product_variant #product_add_variant_group').fadeIn();
    }

    $(this).parent().parent().parent().remove();

    if ($('#product_variant .product-variant').length < 1) {
        $('#product_add_variant').fadeIn();
        $('.not-variant').fadeIn();

        $('#product_variant').hide();
        $('#is_variant').val(0);

        return true;
    }

    if ($('#product_variant .product-variant').length == 1) {
        $("#product_variant .product-variant-group .product-variant-close button").prop("disabled", false);
    } else {
        $("#product_variant .product-variant-group .product-variant.has-image .product-variant-close button").prop("disabled", true);
    }

    showListVariantSku();

    checkDisableList();

    return true;
});

$(document).on('keyup', '#product_variant .variant-name', function() {
    if ($(this).val().length) {
        $(this).parent().find('.variant-name-length').html($(this).val().length);
    } else {
        $(this).parent().find('.variant-name-length').html(0);
    }

    if ($(this).hasClass('default')) {
        var variant_value = $(this);
        clearTimeout(timeout_variant);
        timeout_iconpicker = setTimeout(function () {
            $('td[data-variant-name="row_' + variant_value.data('variant-value-row') + '_name"]').html(variant_value.val());
            //showListVariantSku();
        }, 500);
    }
});

$(document).on('change', '#product_variant select', function() {
    //showListVariantSku();
    var variant_data = $(this);

    if (variant_data.find('option:selected').val() != "" && variant_data.find('option:selected').val() > 0) {
        $('#td_' + variant_data.attr('id')).html(variant_data.find('option:selected').text());
    } else {
        $('#td_' + variant_data.attr('id')).html($('#product_variant #product_variant_info table thead tr').data('variant'));
    }

    checkDisableList();
});

function checkDisableList() {
    var variant_selected = [];
    $('#product_variant select').each(function(index, variant) {

        if ($(variant).find('option:selected').val() != "" && $(variant).find('option:selected').val() > 0) {
            variant_selected[$(variant).attr('id')] = $(variant).find('option:selected').val();
        }

        $('#' + $(variant).attr('id') + " option").prop('disabled', false);
    });

    for (key in variant_selected) {
        $('#product_variant select').each(function (index, variant) {
            //for (key in option_selected) {
            if ($(variant).attr('id') == key && $(variant).find('option:selected').val() == variant_selected[key]) {
                return;
            }
            $('#' + $(variant).attr('id') + " option[value*='" + variant_selected[key] + "']").prop('disabled', true);
        });
    }
}

function showListVariantSku() {
    if (is_product_processing) {
        return;
    }
    is_product_processing = true;

    var product_variant_row       = $('#product_variant_row').val();
    var product_variant_value_row = $('#product_variant_value_row').val();

    var html_variant_header = "";
    var variant_count = 1;

    $('#product_variant select').each(function() {
        if ($(this).find('option:selected').val() && $(this).find('option:selected').val() != "" && $(this).find('option:selected').val() > 0) {
            html_variant_header += '<td id="td_' + $(this).attr('id') + '" class="variant-name">' + $(this).find('option:selected').text() + '</td>';
        } else {
            html_variant_header += '<td id="td_' + $(this).attr('id') + '" class="variant-name">' + $('#product_variant #product_variant_info table thead tr').data('variant') + ' ' + variant_count + '</td>';
        }
        variant_count = variant_count + 1;
    });

    html_variant_header += '<td class="required-label">' + $('#product_variant #product_variant_info table thead tr').data('price') + '</td>';
    html_variant_header += '<td class="required-label">' + $('#product_variant #product_variant_info table thead tr').data('quantity') + '</td>';
    html_variant_header += '<td>' + $('#product_variant #product_variant_info table thead tr').data('sku') + '</td>';
    html_variant_header += '<td>' + $('#product_variant #product_variant_info table thead tr').data('published') + '</td>';

    $('#product_variant #product_variant_info table thead tr').html(html_variant_header);

    var html_variant_tr     = "";
    var variant_info_row_id = "";
    var variant_list        = $('#product_variant .product-variant');

    var variant_data_list = [];
    var return_list = [];
    var prev_variants = variant_list[0];
    $.each(variant_list, function (index, value) {
        if (index == 0) return;
        $(this).find('.variant-name.default').each(function (index, value) {
            var temp_list = [];

            temp_list = $.map(prev_variants, function (v, i) {
                return v + ' ' + value;
            });
            return_list = $.merge(return_list, temp_list);
        });

        return_list = $.grep(return_list, function (i) {
            return $.inArray(i, prev_variants) == -1;
        });

        prev_variants = return_list.slice(0);
    });

    if (variant_list.eq(2).length) {
        var total_variant_value_2 = parseInt($('#product_variant #product_variant_row_' + variant_list.eq(1).data('row') + ' .variant-name.default').length);
        var total_variant_value_3 = parseInt($('#product_variant #product_variant_row_' + variant_list.eq(2).data('row') + ' .variant-name.default').length);
        $('#product_variant #product_variant_row_' + variant_list.eq(0).data('row') + ' .variant-name.default').each(function(index_variant_1, variant_1) {
            $('#product_variant #product_variant_row_' + variant_list.eq(1).data('row') + ' .variant-name.default').each(function(index_variant_2, variant_2) {
                $('#product_variant #product_variant_row_' + variant_list.eq(2).data('row') + ' .variant-name.default').each(function(index_variant_3, variant_3) {

                    // if ($(option_1).val() == '' || $(option_1).val() === undefined || $(option_2).val() == '' || $(option_2).val() === undefined || $(option_3).val() == '' || $(option_3).val() === undefined) {
                    //     return;
                    // }

                    variant_info_row_id = product_variant_combination_sku_name + $(variant_1).data('variant-value-row') + '_' + $(variant_2).data('variant-value-row') + '_' + $(variant_3).data('variant-value-row');

                    variant_name_row_1 = 'row_' + $(variant_1).data('variant-value-row') + '_name';
                    variant_name_row_2 = 'row_' + $(variant_2).data('variant-value-row') + '_name';
                    variant_name_row_3 = 'row_' + $(variant_3).data('variant-value-row') + '_name';

                    html_variant_tr += '<tr id="' + variant_info_row_id + '">';
                    // if (index_variant_2 == 0 && index_variant_3 == 0) {
                    //     html_variant_tr += '<td data-variant-name="' + variant_name_row_1 + '" class="variant-name text-center" rowspan="' + parseInt(total_variant_value_2 * total_variant_value_3) + '">' + $(variant_1).val() + '</td>';
                    // }
                    //
                    // if (index_variant_3 == 0) {
                    //     html_variant_tr += '<td data-variant-name="' + variant_name_row_2 + '" class="variant-name text-center" rowspan="' + total_variant_value_3 + '">' + $(variant_2).val() + '</td>';
                    // }

                    html_variant_tr += '<td data-variant-name="' + variant_name_row_1 + '" class="variant-name text-center">' + $(variant_1).val() + '</td>';
                    html_variant_tr += '<td data-variant-name="' + variant_name_row_2 + '" class="variant-name text-center">' + $(variant_2).val() + '</td>';
                    html_variant_tr += '<td data-variant-name="' + variant_name_row_3 + '" class="variant-name text-center">' + $(variant_3).val() + '</td>';

                    html_variant_tr += setInputItemVariant(variant_info_row_id);
                    html_variant_tr += '</tr>';

                    variant_data_list = $.merge(variant_data_list, getInputItemVariant(variant_info_row_id));

                });
            });
        });
    } else if (variant_list.eq(1).length) {
        var total_variant_value = parseInt($('#product_variant #product_variant_row_' + variant_list.eq(1).data('row') + ' .variant-name.default').length);

        $('#product_variant #product_variant_row_' + variant_list.eq(0).data('row') + ' .variant-name.default').each(function(index_variant_1, variant_1) {
            $('#product_variant #product_variant_row_' + variant_list.eq(1).data('row') + ' .variant-name.default').each(function(index_variant_2, variant_2) {
                // if ($(option_1).val() == '' || $(option_1).val() === undefined || $(option_2).val() == '' || $(option_2).val() === undefined) {
                //     return;
                // }

                variant_info_row_id = product_variant_combination_sku_name + $(variant_1).data('variant-value-row') + '_' + $(variant_2).data('variant-value-row');

                variant_name_row_1 = 'row_' + $(variant_1).data('variant-value-row') + '_name';
                variant_name_row_2 = 'row_' + $(variant_2).data('variant-value-row') + '_name';

                html_variant_tr += '<tr id="' + variant_info_row_id + '">';
                // if (index_variant_2 === 0) {
                //     html_variant_tr += '<td data-variant-name="' + variant_name_row_1 + '" class="variant-name text-center" rowspan="' + total_variant_value + '">' + $(variant_1).val() + '</td>';
                // }
                html_variant_tr += '<td data-variant-name="' + variant_name_row_1 + '" class="variant-name text-center">' + $(variant_1).val() + '</td>';
                html_variant_tr += '<td data-variant-name="' + variant_name_row_2 + '" class="variant-name text-center">' + $(variant_2).val() + '</td>';

                html_variant_tr += setInputItemVariant(variant_info_row_id);
                html_variant_tr += '</tr>';

                variant_data_list = $.merge(variant_data_list, getInputItemVariant(variant_info_row_id));

            });
        });

    } else {

        $('#product_variant #product_variant_row_' + variant_list.eq(0).data('row') + ' .variant-name.default').each(function() {
            // if ($(this).val() == '' || $(this).val() === undefined) {
            //     return;
            // }
            variant_info_row_id = product_variant_combination_sku_name + $(this).data('variant-value-row');

            variant_name_row    = 'row_' + $(this).data('variant-value-row') + '_name';

            html_variant_tr += '<tr id="' + variant_info_row_id + '">';
            html_variant_tr += '<td data-variant-name="' + variant_name_row + '" class="variant-name text-center">' + $(this).val() + '</td>';
            html_variant_tr += setInputItemVariant(variant_info_row_id);
            html_variant_tr += '</tr>';

            variant_data_list = $.merge(variant_data_list, getInputItemVariant(variant_info_row_id));

        });
    }

    //if (html_variant_tr != "") {
        $('#product_variant #product_variant_info table tbody').html(html_variant_tr).fadeIn();
    //}
    // else {
    //     $('#product_variant #product_variant_info table tbody').html('<tr><td>Không có SKU nào sẵn có</td></tr>');
    // }

    $.each(variant_data_list, function (index, value) {
        if (value.row_id.includes('published')) {
                        $('#' + value.row_id + ' input').prop('checked', value.value);
        } else if (value.row_id.includes('product_sku_id')) {
            $('#' + value.row_id).val(value.value);
        } else {
            $('#' + value.row_id + ' input').val(value.value);
        }
    });

    is_product_processing = false;
}

function getInputItemVariant(variant_info_row_id) {

    var variant_data_list = [];

    if ($('#' + variant_info_row_id + '_product_sku_id').length) {
        variant_data_list.push({
            row_id: variant_info_row_id + '_product_sku_id',
            value: $('#' + variant_info_row_id + '_product_sku_id').val()
        });
    }

    if ($('#' + variant_info_row_id + '_price').length) {
        variant_data_list.push({
            row_id: variant_info_row_id + '_price',
            value: $('#' + variant_info_row_id + '_price input').val()
        });
    }

    if ($('#' + variant_info_row_id + '_quantity').length) {
        variant_data_list.push({
            row_id: variant_info_row_id + '_quantity',
            value: $('#' + variant_info_row_id + '_quantity input').val()
        });
    }

    if ($('#' + variant_info_row_id + '_sku').length) {
        variant_data_list.push({
            row_id: variant_info_row_id + '_sku',
            value: $('#' + variant_info_row_id + '_sku input').val()
        });
    }

    if ($('#' + variant_info_row_id + '_published').length) {
        variant_data_list.push({
            row_id: variant_info_row_id + '_published',
            value: $('#' + variant_info_row_id + '_published input').is(':checked')
        });
    }

    return variant_data_list;
}

function setInputItemVariant(variant_info_row_id)
{
    var htm_td = $('#html_product_variant_value_form_td table tr').html();

    htm_td = htm_td.replaceAll('__variant_info_row_id__', variant_info_row_id).replaceAll('data-id', 'id');

    return htm_td;
}

$(document).on('click', '#product_variant .variant-list .btn-variant-update-bulk', function() {

    if ($('#product_variant .variant-list #input_product_variant_combination_price_all').val() && $('#product_variant .variant-list #input_product_variant_combination_price_all').val() != "") {
        $('#product_variant .variant-list .variant-combination-price input').val($('#product_variant .variant-list #input_product_variant_combination_price_all').val());
    }
    if ($('#product_variant .variant-list #input_product_variant_combination_quantity_all').val() && $('#product_variant .variant-list #input_product_variant_combination_quantity_all').val() >= 0) {
        $('#product_variant .variant-list .variant-combination-quantity input').val($('#product_variant .variant-list #input_product_variant_combination_quantity_all').val());
    }
    if ($('#product_variant .variant-list #input_product_variant_combination_sku_all').val() && $('#product_variant .variant-list #input_product_variant_combination_sku_all').val() != "") {
        $('#product_variant .variant-list .variant-combination-sku input').val($('#product_variant .variant-list #input_product_variant_combination_sku_all').val());
    }
});