var is_processing = false;

/* action - event */
$(function () {
    /** filemanager **/
    if ($('a[data-bs-toggle=\'image\'] .button-image').length) {
        $(document).on('click', 'a[data-bs-toggle=\'image\'] .button-image', function (e) {
            if (is_processing) {
                return false;
            }
            is_processing = true;
            e.preventDefault();

            $('#modal-image').remove();//target=$element.parent().find('input').attr('id')
            var element = $(this);
            $.ajax({
                url: 'common/filemanager?target=' + encodeURIComponent(element.parent().attr('data-target')) + '&thumb=' + encodeURIComponent(element.parent().attr('data-thumb')),
                dataType: 'html',
                beforeSend: function () {
                    element.find('i').replaceWith('<i class="fas fa-spinner fa-spin me-1"></i>');
                },
                complete: function () {
                    element.find('i').replaceWith('<i class="fas fa-pencil-alt me-1"></i>');
                },
                success: function (html) {
                    is_processing = false;

                    $('body').append('<div id="modal-image" class="modal fade" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">' + html + '</div>');
                    $('#modal-image').modal('show');
                },
                error: function (xhr, errorType, error) {
                    is_processing = false;
                }
            });
        });
    }
    if ($('a[data-bs-toggle=\'image\'] .button-clear').length) {
        $(document).on('click', 'a[data-bs-toggle=\'image\'] .button-clear', function (e) {
            e.preventDefault();
            $($(this).parent().attr('data-target')).val('');
            $(this).parent().find('img').attr('src', $(this).parent().find('img').attr('data-placeholder'));
            $($(this).parent()).parent().find('input').val('');
        });
    }
    $(document).on('hidden.bs.modal, hide.bs.modal','#modal-image', function () {
        $('#button-folder').popover('dispose');
    });
    /** filemanager **/
});

