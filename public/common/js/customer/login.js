var is_processing = false;

$('.social-list .social-item').on('click', function(e) {
    if (is_processing) {
        return false;
    }

    is_processing = true;
    $.ajax({
        url: base_url + '/customers/social_login',
        type: 'POST',
        data: {type: $(this).data('type')},
        success: function (data) {
            is_processing = false;

            var response = JSON.stringify(data);
            response = JSON.parse(response);

            if (response.status == 'ng') {
                $.notify(response.msg, {'type': 'danger'});
                return false;
            }

            if (response.auth_url != '') {
                var win_popup = popupwindow(response.auth_url, "popup_login", 400, 600);
                var pollTimer = window.setInterval(function() {
                    try {
                        //console.log(win_popup.document.URL);
                        if (win_popup.document.URL.indexOf('returnUrl') != -1) {
                            window.clearInterval(pollTimer);
                            var url = win_popup.document.URL;

                            win_popup.close();
                        }
                    } catch(e) {
                    }
                }, 100);

                //window.location = response.auth_url;
                return false;
            } else if (response.status == 'redirect') {
                window.location = response.url;
                return false;
            } else {
                location.reload();
            }
        },
        error: function (xhr, errorType, error) {
            is_processing = false;
        }
    });
});

function popupwindow(url, title, w, h) {
    var y = window.outerHeight / 2 + window.screenY - ( h / 2)
    var x = window.outerWidth / 2 + window.screenX - ( w / 2)
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + y + ', left=' + x);
}

/* action - event */
$(function () {

});

