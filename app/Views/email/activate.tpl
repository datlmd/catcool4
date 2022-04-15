{strip}
	<html>
		<body>
			<h3 style="padding:10px 0">{lang('Email.text_welcome', [ucwords(config_item('site_name'))])}</h3>
			<p>{lang('Email.activate_content_1')}</p>
			<p>
				{if !empty($is_admin)}
					<a href='{site_url("users_admin/activate/$id/$activation")}' style="background:#4184f3;height:46px;margin:10px 0;padding:0 40px;line-height:46px;border-radius:4px;font-size:18px;color:#fff;display:inline-block;text-decoration: none;">
						{lang('Email.activate_link')}
					</a>
				{else}
					<a href='{site_url("users/activate/$id/$activation")}' style="background:#4184f3;height:46px;margin:10px 0;padding:0 40px;line-height:46px;border-radius:4px;font-size:18px;color:#fff;display:inline-block;text-decoration: none;">
						{lang('Email.activate_link')}
					</a>
				{/if}
			</p>
			<p>
				{if !empty($is_admin)}
					<a href='{site_url("users_admin/activate/$id/$activation")}'>{site_url("users/activate/$id/$activation")}</a>
				{else}
					<a href='{site_url("users/activate/$id/$activation")}'>{site_url("users/activate/$id/$activation")}</a>
				{/if}
			</p>
			<p style="padding-top: 5px;">{lang('Email.activate_content_2')}</p>
			<p style="padding-top: 10px; color: #76808f;">{lang('Email.text_signature', [ucwords(config_item('site_name'))])}</p>
			<p style="padding-top:30px; color: #76808f;">{lang('Email.text_automate')}</p>
		</body>
	</html>
{/strip}
