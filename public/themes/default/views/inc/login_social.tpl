<div class="text-center">Với mạng xã hội của bạn.</div>
<div class="social-list text-center">
	<a href="javascript:;" rel="nofollow" data-type="fb" onclick="fbLogin(this)" class="social-item fb btn">
		<i class="fab fa-facebook-f"></i> Facebook
	</a>
    {*<a href="#" rel="nofollow" data-type="tt" class="social-item twitter btn my-3">*}
    {*<i class="fa fa-twitter fa-fw"></i> Twitter*}
    {*</a>*}
	<a href="javascript:;" rel="nofollow" data-type="gg" class="social-item google btn">
		<i class="fab fa-google"></i> Google
	</a>
	<a href="javascript:;" rel="nofollow" data-type="zalo" class="social-item zalo btn my-3">Zalo</a>
</div>
<script type="application/javascript">
	var is_processing = false;

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
			url: base_url + '/customers/social_login',
			type: 'POST',
			data: {
				type: login_type,
				access_token: access_token_value,
			},
			success: function (data) {
				is_processing = false;

				var response = JSON.stringify(data);
				response = JSON.parse(response);

				if (response.status == 'ng') {
					$.notify(response.msg, {'type': 'danger'});
					return false;
				}

				if (response.auth_url != '') {
					if (login_type == 'gg' || login_type == 'zalo') {
						var win_popup = popupWindow(response.auth_url, "popup_login", 600, 700);
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
					} else {
						window.location = response.auth_url;
					}

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
	}

	$('.social-list .social-item').on('click', function(e) {
		if ($(this).data('type') == 'fb') {
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
