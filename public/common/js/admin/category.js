var is_processing = false;

function submitSort () {
    if (is_processing) {
        return false;
    }
    $('[data-toggle=\'tooltip\']').tooltip('dispose');
    $('[data-toggle=\'tooltip\']').tooltip();
    is_processing = true;

    // CSRF Hash
    var csrfName = $('#cc_token').attr('name'); // CSRF Token name
    var csrfHash = $('#cc_token').val(); // CSRF hash

    $.ajax({
        url: current_url + '/update_sort',
        type: 'POST',
        data: {ids: JSON.stringify($('.dd').nestable('serialize')), [csrfName]: csrfHash},
        beforeSend: function () {
            $('#btn_category_sort').find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
        },
        complete: function () {
            $('#btn_category_sort').find('i').replaceWith('<i class="fas fa-save me-1"></i>');
        },
        success: function (data) {
            is_processing = false;

            var response = JSON.stringify(data);
            response = JSON.parse(response);

            if (response.token) {
                // Update CSRF hash
                $('#cc_token').val(response.token);
            }

            if (response.status == 'redirect') {
                window.location = response.url;
                return false;
            } else if (response.status == 'ng') {
                $.notify(response.msg, {'type': 'danger'});
                return false;
            } else if (response.status == 'reload') {
                location.reload();
                return false;
            }

            $.notify(response.msg);
        },
        error: function (xhr, errorType, error) {
            is_processing = false;
        }
    });
}
/* action - event */
$(function () {
    if ($("#list_category_sort").length) {
        $('#list_category_sort').nestable('serialize');
    }
    $('#list_category_sort').on('change', function(e) {
        if ($(e.target).closest('#list_category_sort .dd-nodrag').length != 0) {
            return true;
        }
        $("#btn_category_sort").show();
    });
});

