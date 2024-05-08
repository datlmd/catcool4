<div class="text-center">{lang('General.text_login_with')}</div>
<div class="social-list text-center">
	<a href="javascript:;" rel="nofollow" data-type="{LOGIN_SOCIAL_TYPE_FACEBOOK}" onclick="fbLogin(this)" class="social-item fb btn">
		<i class="fab fa-facebook-f"></i> Facebook
	</a>
    {*<a href="#" rel="nofollow" data-type="tt" class="social-item twitter btn my-3">*}
    {*<i class="fa fa-twitter fa-fw"></i> Twitter*}
    {*</a>*}
	<a href="javascript:;" rel="nofollow" data-type="{LOGIN_SOCIAL_TYPE_GOOGLE}" class="social-item google btn">
		<i class="fab fa-google"></i> Google
	</a>
	<a href="javascript:;" rel="nofollow" data-type="{LOGIN_SOCIAL_TYPE_ZALO}" class="social-item zalo btn my-3">Zalo</a>
</div>

{csrf_meta()}

<script type="application/javascript">
	var is_processing = false;

	{if !empty($return_url)}
		var return_url = '{$return_url}';
	{else}
		var return_url = '{site_url()}';
	{/if}

	{literal}

	window.fbAsyncInit = function() {
		FB.init({
			appId   : '{/literal}{config_item('fb_app_id')}{literal}',
			cookie  : true,
			xfbml   : true,
			oauth   : false,
			version : '{/literal}{config_item('fb_graph_version')}{literal}'
		});

		FB.AppEvents.logPageView();
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = 'https://connect.facebook.net/en_US/sdk.js';
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	function fbLogin(obj) {
		FB.login(function (response) {
			if (response.status === 'connected' && response.authResponse) {
				//console.log(response);
				loginSocial($(obj).data('type'), response.authResponse.accessToken)
			} else {
				console.log('User cancelled login or did not fully authorize.');
			}
		}, { scope: 'email,public_profile' });
	}

	function loginSocial(login_type, access_token_value) {
		if (is_processing) {
			return false;
		}

		if (!access_token_value || access_token_value == "undefined") {
			access_token_value = '';
		}

		is_processing = true;
		$.ajax({
			url: 'account/social_login',
			type: 'POST',
			data: {
				type: login_type,
				access_token: access_token_value,
				[$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
			},
			dataType: 'json',
            cache: false,
            contentType: 'application/x-www-form-urlencoded',
			success: function (data) {
				is_processing = false;

				var response = JSON.stringify(data);
				response = JSON.parse(response);

				if (response.status == 'ng') {
					$.notify(response.msg, {'type': 'danger'});
					return false;
				}

				if (response.status == 'logged_in') {
					window.location = return_url;
					return false;
				}

				if (response.auth_url != '' && response.auth_url != 'undefined') {
					if (login_type == '{/literal}{LOGIN_SOCIAL_TYPE_GOOGLE}{literal}' || login_type == '{/literal}{LOGIN_SOCIAL_TYPE_ZALO}{literal}') {
						var win_popup = popupWindow(response.auth_url, "popup_login", 600, 700);
						var pollTimer = window.setInterval(function() {
							try {
								//console.log(win_popup.document.URL);
								if (win_popup.document.URL.indexOf('logged_in') != -1) {
									window.clearInterval(pollTimer);
									var url = win_popup.document.URL;

									win_popup.close();

									window.location = return_url;
								}
							} catch(e) {
								console.log('User cancelled login or did not fully authorize.');
							}
						}, 100);
					}
					return false;
				} else {
					location.reload();
				}
			},
			error: function (xhr, errorType, error) {
				is_processing = false;
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}

	$('.social-list .social-item').on('click', function(e) {
		if ($(this).data('type') == '{/literal}{LOGIN_SOCIAL_TYPE_FACEBOOK}{literal}') {
			return;
		}
		loginSocial($(this).data('type'));
	});

	function popupWindow(url, title, w, h) {
		var y = window.outerHeight / 2 + window.screenY - ( h / 2)
		var x = window.outerWidth / 2 + window.screenX - ( w / 2)
		return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + y + ', left=' + x);
	}

	{/literal}
</script>
