var is_releated_processing = false;
var logical_off = false;

function relatedKeypress(obj) {
    if (logical_off) {
        return true;
    }

    logical_off = true; // stop keypress function
    setTimeout(function () { // restart keypress function
        logical_off = false;
        console.log(12);
        searchRelated(obj);
    }, 1000);
}

function searchRelated(obj) {
    if (is_releated_processing) {
        return false;
    }

    var related_div = $(obj).parent().parent();
    var related_url = related_div.data('url');

    is_releated_processing = true;
    $.ajax({
        url: related_url,
        type: 'POST',
        data: {
            related: related_div.find('input').val(),
            id: related_div.data('id'),
        },
        beforeSend: function () {
            related_div.find('.related-form').find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
        },
        complete: function () {
            related_div.find('.related-form').find('i').replaceWith('<i class="fa fa-search"></i>');
        },
        success: function (data) {
            is_releated_processing = false;

            var response = JSON.stringify(data);
            response = JSON.parse(response);

            if (response.status == 'ng') {
                $.notify(response.msg, {'type': 'danger'});
                return false;
            }
            related_div.find('.related-result').show();
            related_div.find('.related-data').html(response.view);
        },
        error: function (xhr, errorType, error) {
            $.notify(xhr.responseJSON.message, {'type': 'danger'});
            is_releated_processing = false;
        }
    });

    return false;
}
