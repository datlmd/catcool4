
<style>
	body {
		background: url({img_url(config_item('background_image_admin_path'))}) no-repeat center center; background-size: cover;
	}
</style>
<div class="splash-container">
	<div class="card">
		<div class="card-header text-center">
			{include file=get_theme_path('views/inc/logo.tpl') lodo_sub_class="text-dark"}
		</div>
		<div class="card-body pt-4">
			<div class="splash-description mb-1">{lang('UserAdmin.text_reset_password_heading')}</div>
			{if !empty(print_flash_alert())}
                <div class="col-12">{print_flash_alert()}</div>
            {/if}
			{if !empty($errors)}
				{include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
			{/if}
			{form_open($reset_password)}
				<div class="form-group mb-3">
					{lang('Admin.text_username')}: <strong>{$user.username}</strong> ({full_name($user.first_name, $user.last_name)})
				</div>
				<div class="form-group mb-3">
					{lang('UserAdmin.text_reset_password')}
					<input type="password" name="new_password" value='{set_value("new_password")}' id="password" class="form-control">
				</div>
				<div class="form-group mb-3">
					{lang('UserAdmin.text_reset_password_confirm')}
					<input type="password" name="new_password_confirm" value='{set_value("new_password_confirm")}' id="new_password_confirm" class="form-control">
				</div>
				{form_hidden('user_id', $user.user_id)}

				<button type="submit" class="btn btn-primary btn-lg btn-block mt-2 w-100">{lang('UserAdmin.button_reset_password')}</button>
			{form_close()}
		</div>
		<div class="card-footer bg-white text-center p-0">
			<div class="row m-0 p-0">
				<div class="card-footer-item card-footer-item-bordered col-6">
					{anchor("users/manage/login", lang('UserAdmin.text_login'), 'class="footer-link"')}
				</div>
				<div class="card-footer-item card-footer-item-bordered col-6">
					{anchor("users/manage/forgot_password", lang('Admin.text_forgot_password'), 'class="footer-link"')}
				</div>
			</div>
		</div>
	</div>
</div>