var is_uploading = false;
$(function() {
    // preventing page from redirecting
    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('.upload-area h5').removeClass('upload-drop');
        console.log(1);
    });

    $("html").on("drop", function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log(2);
    });

    // Drag enter .upload-area
    $('body').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $('.upload-area h5').removeClass('upload-drop');
        console.log(3);
    });

    // Drag over class .upload-area
    $('body').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $('.upload-area h5').addClass('upload-drop');
        console.log(4);
    });

    // Drop
    $('body').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        //$("h5").text("Upload");
        var file = e.originalEvent.dataTransfer.files;
        var fd = new FormData();

        fd.append('file', file[0]);

        uploadData(fd);
    });

    // Open file selector on div click
    $(document).on('click', ".drop-drap-file .upload-area", function(obj) {
        $("#file").click();
    });

    // file selected
    $(document).on('change', ".drop-drap-file #file", function(obj) {
        var fd = new FormData();

        var files = $('#file')[0].files[0];

        fd.append('file',files);

        uploadData(fd);
    });

});

// Sending AJAX request and upload file
function uploadData(formdata) {
    if (is_uploading) {
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

        is_uploading = true;
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
            success: function(data){
                is_uploading = false;
                $('.loading').fadeOut();
                $('.drop-drap-file .progress').remove().fadeOut();
                $('.upload-area h5').removeClass('upload-drop');

                var response = JSON.stringify(data);
                response     = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type':'danger'});
                    return false;
                }
                addThumbnail(response);
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').fadeOut();
                $('.drop-drap-file .progress').remove().fadeOut();
                $('.upload-area h5').removeClass('upload-drop');
            }
        });
    }, 500);
}

function delete_file(obj) {
    if (is_uploading) {
        return false;
    }
    $('.loading').fadeIn();

    var image_url = $(obj).attr("data-image-url");
    var image_thumb = $(obj).attr("data-thumb");
    var from_action = $('.drop-drap-file').attr("data-from");

    if (from_action.length && from_action == 'edit') {
        $('#' + image_thumb).hide().fadeOut();
        $('.loading').fadeOut();
    } else {
        is_uploading = true;
        $.ajax({
            url: 'photos/upload/do_delete',
            type: 'POST',
            data: {'image_url': image_url},
            dataType: 'json',
            success: function (data) {
                is_uploading = false;
                $('.loading').fadeOut();
                var response = JSON.stringify(data);
                response = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type': 'danger'});
                    return false;
                }
                $('#' + image_thumb).hide().fadeOut();
                $.notify(response.msg);
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').fadeOut();
            }
        });
    }
}

// Added thumbnail
function addThumbnail(data) {
    var image_id = $(".drop-drap-file").attr("data-image-id");
    var input_name = $(".drop-drap-file").attr("data-input-name");
    var image_class = $(".drop-drap-file").attr("data-image-class");

    if (!image_class.length) {
        image_class = 'img-fluid';
    }

    var name = data.file.name;
    var size = convertSize(data.file.size);
    var src = image_url + '/' + data.image;

    var image_html = '<a href="' + src + '" data-lightbox="photos"><img src="' + src + '" style="background-image: url(' + src + ');" class="' + image_class + '"></a>';
    image_html += '<input type="hidden" name="' + input_name + '" value="' + data.image + '">';

    if ($("#button-image-crop").length) {
        $("#button-image-crop").attr("onclick", "Catcool.cropImage('" + data.image  + "', 1);");
        $("#button-image-crop").show();
    }

    $(".drop-drap-file #" + image_id).html(image_html);
}

// Bytes conversion
function convertSize(size) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (size == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
    return Math.round(size / Math.pow(1024, i), 2) + ' ' + sizes[i];
}